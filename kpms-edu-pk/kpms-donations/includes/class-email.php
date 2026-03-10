<?php
if (!defined('ABSPATH')) exit;

class KPMS_Email {

    /**
     * Send pledge confirmation to donor (with payment instructions)
     */
    public static function send_pledge_confirmation($donation) {
        if (get_option('kpms_don_test_mode') === 'yes') return true;

        $subject = 'KPMS Donation Pledge Received — ' . $donation->transaction_reference;
        $body = self::build_pledge_email($donation);

        return self::send($donation->donor_email, $subject, $body);
    }

    /**
     * Send receipt after admin confirms payment
     */
    public static function send_receipt($donation) {
        if (get_option('kpms_don_test_mode') === 'yes') return true;

        $subject = 'JazakAllah Khair — Your KPMS Donation Has Been Confirmed';
        $body = self::build_receipt_email($donation);

        return self::send($donation->donor_email, $subject, $body);
    }

    /**
     * Notify admin of new pledge
     */
    public static function send_admin_notification($donation) {
        if (get_option('kpms_don_test_mode') === 'yes') return true;

        $admin_email = get_option('kpms_don_admin_email', get_option('admin_email'));
        $type = ucfirst($donation->donation_type);
        $amount = '$' . number_format($donation->amount, 2);

        $subject = "[KPMS] New {$type} Donation Pledge — {$amount}";
        $body = "<div style='font-family:Arial,sans-serif;max-width:500px;margin:0 auto;padding:20px;'>"
              . "<h2 style='color:#003087;'>New Donation Pledge</h2>"
              . "<p><strong>Donor:</strong> {$donation->donor_name}</p>"
              . "<p><strong>Email:</strong> {$donation->donor_email}</p>"
              . "<p><strong>Amount:</strong> {$amount}</p>"
              . "<p><strong>Type:</strong> {$type}</p>"
              . "<p><strong>Reference:</strong> {$donation->transaction_reference}</p>"
              . "<p><strong>Method:</strong> " . ucfirst($donation->payment_method) . "</p>"
              . "<p style='margin-top:20px;'><a href='" . admin_url('admin.php?page=kpms-donations') . "' style='background:#003087;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px;'>View in Dashboard</a></p>"
              . "</div>";

        return self::send($admin_email, $subject, $body);
    }

    /**
     * Build pledge confirmation email
     */
    private static function build_pledge_email($d) {
        $amount = '$' . number_format($d->amount, 2);
        $type = ucfirst($d->donation_type);
        $zelle_email = get_option('kpms_don_zelle_email', '');
        $zelle_phone = get_option('kpms_don_zelle_phone', '');

        $zelle_html = '';
        if ($zelle_email || $zelle_phone) {
            $zelle_html = "<div style='background:#f0f7ff;border:1px solid #003087;border-radius:8px;padding:16px;margin:12px 0;'>"
                        . "<h4 style='color:#003087;margin:0 0 8px;'>Send via Zelle</h4>";
            if ($zelle_email) $zelle_html .= "<p style='margin:4px 0;'><strong>Email:</strong> {$zelle_email}</p>";
            if ($zelle_phone) $zelle_html .= "<p style='margin:4px 0;'><strong>Phone:</strong> {$zelle_phone}</p>";
            $zelle_html .= "<p style='margin:4px 0;'><strong>Memo:</strong> {$d->transaction_reference}</p></div>";
        }

        $wire_html = '';
        $wire_bank = get_option('kpms_don_wire_bank', '');
        if ($wire_bank) {
            $wire_html = "<div style='background:#fff9e6;border:1px solid #FFD100;border-radius:8px;padding:16px;margin:12px 0;'>"
                       . "<h4 style='color:#003087;margin:0 0 8px;'>Wire Transfer</h4>"
                       . "<p style='margin:4px 0;'><strong>Bank:</strong> {$wire_bank}</p>"
                       . "<p style='margin:4px 0;'><strong>Routing:</strong> " . get_option('kpms_don_wire_routing', '') . "</p>"
                       . "<p style='margin:4px 0;'><strong>Account:</strong> " . get_option('kpms_don_wire_account', '') . "</p>";
            $swift = get_option('kpms_don_wire_swift', '');
            if ($swift) $wire_html .= "<p style='margin:4px 0;'><strong>SWIFT:</strong> {$swift}</p>";
            $wire_html .= "<p style='margin:4px 0;'><strong>Memo:</strong> {$d->transaction_reference}</p></div>";
        }

        $impact = self::get_impact_text($d->amount);

        return self::email_wrapper("
            <h2 style='color:#003087;margin:0 0 4px;'>JazakAllah Khair, {$d->donor_name}!</h2>
            <p style='color:#666;font-size:14px;'>Your donation pledge has been recorded.</p>

            <div style='background:#f8f9fa;border-radius:8px;padding:16px;margin:20px 0;text-align:center;'>
                <p style='font-size:32px;font-weight:700;color:#003087;margin:0;'>{$amount}</p>
                <p style='font-size:14px;color:#666;margin:4px 0 0;'>{$type} Donation</p>
                <p style='font-size:13px;color:#999;margin:4px 0 0;'>Ref: {$d->transaction_reference}</p>
            </div>

            <h3 style='color:#003087;'>Payment Instructions</h3>
            <p>Please send your payment using one of the methods below. Include your reference code <strong>{$d->transaction_reference}</strong> in the memo/note.</p>
            {$zelle_html}
            {$wire_html}

            {$impact}

            <div style='background:#f0f7f0;border-left:4px solid #28a745;padding:12px 16px;margin:20px 0;border-radius:0 6px 6px 0;'>
                <p style='margin:0;font-style:italic;color:#333;font-size:13px;'>\"The example of those who spend their wealth in the way of Allah is like a seed which grows seven ears; in each ear is a hundred grains. And Allah multiplies for whom He wills.\"</p>
                <p style='margin:6px 0 0;font-size:12px;color:#666;'>— Quran 2:261</p>
            </div>

            <p style='font-size:13px;color:#666;margin-top:20px;'>100% of your donation goes directly to educating children at KPMS. You will receive a confirmation email once your payment has been verified.</p>
        ");
    }

    /**
     * Build receipt email (after payment confirmed)
     */
    private static function build_receipt_email($d) {
        $amount = '$' . number_format($d->amount, 2);
        $type = ucfirst($d->donation_type);
        $date = date('F j, Y', strtotime($d->confirmed_at ?: $d->created_at));
        $impact = self::get_impact_text($d->amount);

        return self::email_wrapper("
            <div style='text-align:center;margin-bottom:20px;'>
                <div style='width:60px;height:60px;background:#28a745;border-radius:50%;margin:0 auto 12px;line-height:60px;font-size:28px;color:#fff;'>&#10003;</div>
                <h2 style='color:#003087;margin:0;'>Payment Confirmed!</h2>
                <p style='color:#666;'>Thank you for your generous contribution.</p>
            </div>

            <div style='background:#f8f9fa;border-radius:8px;padding:20px;margin:20px 0;'>
                <table style='width:100%;font-size:14px;'>
                    <tr><td style='padding:6px 0;color:#666;'>Donor</td><td style='padding:6px 0;text-align:right;font-weight:600;'>{$d->donor_name}</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Amount</td><td style='padding:6px 0;text-align:right;font-weight:600;color:#003087;'>{$amount}</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Type</td><td style='padding:6px 0;text-align:right;'>{$type}</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Date</td><td style='padding:6px 0;text-align:right;'>{$date}</td></tr>
                    <tr><td style='padding:6px 0;color:#666;'>Reference</td><td style='padding:6px 0;text-align:right;font-family:monospace;'>{$d->transaction_reference}</td></tr>
                </table>
            </div>

            {$impact}

            <div style='background:#f0f7f0;border-left:4px solid #28a745;padding:12px 16px;margin:20px 0;border-radius:0 6px 6px 0;'>
                <p style='margin:0;font-style:italic;color:#333;font-size:13px;'>\"Whoever relieves a believer's distress of the distressful aspects of this world, Allah will rescue him from a difficulty of the difficulties of the Hereafter.\"</p>
                <p style='margin:6px 0 0;font-size:12px;color:#666;'>— Sahih Muslim 2699</p>
            </div>

            <p style='font-size:13px;color:#666;'>This email serves as your donation receipt. Please save it for your records.</p>
        ");
    }

    /**
     * Impact text based on donation amount
     */
    private static function get_impact_text($amount) {
        $impact = '';
        if ($amount >= 1000) {
            $impact = 'Sponsors a full year of education for multiple students';
        } elseif ($amount >= 500) {
            $impact = 'Covers a full year of school supplies for an entire classroom';
        } elseif ($amount >= 200) {
            $impact = 'Provides textbooks and uniforms for 4 students';
        } elseif ($amount >= 150) {
            $impact = 'Funds a month of teacher training and development';
        } elseif ($amount >= 100) {
            $impact = 'Provides school supplies for 2 students for an entire year';
        } elseif ($amount >= 50) {
            $impact = 'Covers one student\'s school supplies for a semester';
        } else {
            $impact = 'Every dollar helps provide quality education';
        }

        return "<div style='background:#fff9e6;border-radius:8px;padding:16px;margin:16px 0;text-align:center;'>"
             . "<p style='margin:0 0 4px;font-size:12px;color:#666;text-transform:uppercase;letter-spacing:1px;'>Your Impact</p>"
             . "<p style='margin:0;font-size:15px;color:#003087;font-weight:600;'>{$impact}</p>"
             . "</div>";
    }

    /**
     * Email wrapper with KPMS branding
     */
    private static function email_wrapper($content) {
        $logo = home_url('/wp-content/uploads/2026/02/Kamal-Public-School-2.png');
        return "<!DOCTYPE html><html><head><meta charset='utf-8'></head><body style='margin:0;padding:0;background:#f4f4f4;'>"
             . "<div style='max-width:600px;margin:0 auto;background:#fff;'>"
             . "<div style='background:#003087;padding:24px;text-align:center;'>"
             . "<img src='{$logo}' alt='KPMS' style='width:50px;height:50px;border-radius:50%;'>"
             . "<h1 style='color:#FFD100;margin:8px 0 0;font-size:18px;'>Kamal Public Middle School</h1>"
             . "<p style='color:rgba(255,255,255,0.7);font-size:12px;margin:4px 0 0;'>Educating Futures Since 1985 — Abbottabad, Pakistan</p>"
             . "</div>"
             . "<div style='padding:24px 32px;'>{$content}</div>"
             . "<div style='background:#f8f9fa;padding:16px 32px;text-align:center;font-size:11px;color:#999;border-top:1px solid #eee;'>"
             . "<p style='margin:0;'>Kamal Public Middle School — Abbottabad, Pakistan</p>"
             . "<p style='margin:4px 0 0;'>info@kpms.edu.pk | kpms.edu.pk</p>"
             . "</div></div></body></html>";
    }

    /**
     * Send HTML email
     */
    private static function send($to, $subject, $html) {
        $headers = [
            'Content-Type: text/html; charset=UTF-8',
            'From: KPMS Donations <info@kpms.edu.pk>',
        ];
        return wp_mail($to, $subject, $html, $headers);
    }
}
