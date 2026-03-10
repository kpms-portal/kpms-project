<?php
if (!defined('ABSPATH')) exit;

class KPMS_Donation_Admin {

    public static function init() {
        add_action('admin_menu', [__CLASS__, 'add_menu']);
        add_action('admin_init', [__CLASS__, 'handle_actions']);
        add_action('admin_init', [__CLASS__, 'handle_export']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_styles']);
    }

    public static function enqueue_styles($hook) {
        if (strpos($hook, 'kpms-donations') === false) return;
        wp_enqueue_style('kpms-don-admin', KPMS_DON_URL . 'admin/css/admin.css', [], KPMS_DON_VERSION);
    }

    public static function add_menu() {
        $pending = KPMS_Donation::count_pending();
        $badge = $pending > 0 ? ' <span class="awaiting-mod">' . $pending . '</span>' : '';

        add_menu_page(
            'KPMS Donations',
            'KPMS Donations' . $badge,
            'manage_options',
            'kpms-donations',
            [__CLASS__, 'dashboard_page'],
            'dashicons-heart',
            31
        );

        add_submenu_page(
            'kpms-donations',
            'Settings',
            'Settings',
            'manage_options',
            'kpms-donations-settings',
            [__CLASS__, 'settings_page']
        );
    }

    /**
     * Handle confirm/delete actions before output
     */
    public static function handle_actions() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'kpms-donations') return;
        if (!isset($_GET['don_action']) || !isset($_GET['don_id'])) return;
        if (!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_don_action')) return;

        $id = intval($_GET['don_id']);
        $action = sanitize_text_field($_GET['don_action']);

        if ($action === 'confirm') {
            KPMS_Donation::update_status($id, 'completed');
            $donation = KPMS_Donation::get($id);
            if ($donation) KPMS_Email::send_receipt($donation);
        } elseif ($action === 'delete') {
            KPMS_Donation::delete($id);
        } elseif ($action === 'mark_failed') {
            KPMS_Donation::update_status($id, 'failed');
        }

        wp_redirect(admin_url('admin.php?page=kpms-donations&tab=' . ($_GET['tab'] ?? 'all') . '&msg=' . $action));
        exit;
    }

    /**
     * CSV/Excel export before output
     */
    public static function handle_export() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'kpms-donations') return;
        if (!isset($_GET['kpms_export'])) return;
        if (!current_user_can('manage_options')) return;
        if (!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_don_export')) return;

        $format = sanitize_text_field($_GET['kpms_export']);
        $tab = sanitize_text_field($_GET['tab'] ?? 'all');
        $args = [];
        if ($tab === 'pending') $args['status'] = 'pending';
        elseif ($tab === 'completed') $args['status'] = 'completed';
        elseif ($tab === 'zakat') $args['type'] = 'zakat';
        elseif ($tab === 'sadaqah') $args['type'] = 'sadaqah';
        $donations = KPMS_Donation::list_all($args);

        $headers = ['Date', 'Name', 'Email', 'Phone', 'Amount', 'Type', 'Method', 'Reference', 'Status', 'Message'];

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=kpms-donations-' . $tab . '-' . date('Y-m-d') . '.csv');
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            foreach ($donations as $d) {
                fputcsv($out, self::format_row($d));
            }
            fclose($out);
            exit;
        }

        if ($format === 'excel') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename=kpms-donations-' . $tab . '-' . date('Y-m-d') . '.xls');
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"></head><body><table border="1">';
            echo '<tr>';
            foreach ($headers as $h) echo '<th style="font-weight:bold;background:#003087;color:#fff;">' . $h . '</th>';
            echo '</tr>';
            foreach ($donations as $d) {
                echo '<tr>';
                foreach (self::format_row($d) as $cell) echo '<td>' . htmlspecialchars($cell) . '</td>';
                echo '</tr>';
            }
            echo '</table></body></html>';
            exit;
        }

        if ($format === 'pdf') {
            $date = date('F j, Y');
            $logo = home_url('/wp-content/uploads/2026/02/Kamal-Public-School-2.png');
            $progress = KPMS_Donation::campaign_progress();
            ?>
<!DOCTYPE html><html><head><meta charset="utf-8"><title>KPMS Donations Report</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}body{font-family:'Segoe UI',sans-serif;padding:30px;font-size:12px}
.header{text-align:center;border-bottom:3px solid #003087;padding-bottom:16px;margin-bottom:20px}
.header img{width:50px;height:50px;border-radius:50%}.header h1{color:#003087;font-size:20px;margin:8px 0 2px}
.header p{color:#666;font-size:11px}.meta{display:flex;justify-content:space-between;margin-bottom:12px;font-size:11px;color:#555}
table{width:100%;border-collapse:collapse;font-size:10px}th{background:#003087;color:#fff;padding:6px;text-align:left}
td{padding:5px 6px;border-bottom:1px solid #e0e0e0}tr:nth-child(even) td{background:#f8f9fa}
.summary{display:flex;gap:16px;margin-bottom:16px}
.summary-box{flex:1;text-align:center;background:#f8f9fa;border-radius:6px;padding:12px}
.summary-box .num{font-size:20px;font-weight:700;color:#003087}.summary-box .label{font-size:10px;color:#666;margin-top:2px}
.no-print{text-align:center;margin-bottom:20px}.no-print button{padding:10px 30px;background:#003087;color:#fff;border:none;border-radius:4px;font-size:14px;cursor:pointer;margin:0 6px}
.no-print .close-btn{background:#dc3545}
@media print{.no-print{display:none}th{background:#003087!important;color:#fff!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}tr:nth-child(even) td{background:#f8f9fa!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}}
</style></head><body>
<div class="no-print"><button onclick="window.print()">Print / Save as PDF</button><button class="close-btn" onclick="window.close()">Close</button></div>
<div class="header"><img src="<?php echo esc_url($logo); ?>" alt="KPMS"><h1>Kamal Public Middle School</h1><p>Donations Report — <?php echo esc_html(ucfirst($tab)); ?> — <?php echo $date; ?></p></div>
<div class="summary">
    <div class="summary-box"><div class="num">$<?php echo number_format($progress['total_raised'], 2); ?></div><div class="label">Total Raised</div></div>
    <div class="summary-box"><div class="num"><?php echo $progress['total_donors']; ?></div><div class="label">Donors</div></div>
    <div class="summary-box"><div class="num"><?php echo $progress['percent']; ?>%</div><div class="label">Of Goal</div></div>
</div>
<div class="meta"><span>Total Records: <?php echo count($donations); ?></span><span>Generated: <?php echo date('M j, Y g:i A'); ?></span></div>
<table><thead><tr><?php foreach ($headers as $h) echo "<th>{$h}</th>"; ?></tr></thead><tbody>
<?php foreach ($donations as $d): $r = self::format_row($d); ?>
<tr><?php foreach ($r as $c) echo '<td>' . esc_html($c) . '</td>'; ?></tr>
<?php endforeach; ?></tbody></table>
<script>window.onload=function(){window.print();};</script>
</body></html>
            <?php
            exit;
        }
    }

    private static function format_row($d) {
        return [
            date('Y-m-d H:i', strtotime($d->created_at)),
            $d->donor_name,
            $d->donor_email,
            $d->donor_phone,
            '$' . number_format($d->amount, 2),
            ucfirst($d->donation_type),
            ucfirst($d->payment_method),
            $d->transaction_reference,
            ucfirst($d->payment_status),
            mb_strimwidth($d->donor_message, 0, 80, '...'),
        ];
    }

    /**
     * Dashboard page
     */
    public static function dashboard_page() {
        $tabs = [
            'all'       => 'All Donations',
            'pending'   => 'Pending',
            'completed' => 'Confirmed',
            'zakat'     => 'Zakat',
            'sadaqah'   => 'Sadaqah',
        ];
        $current = sanitize_text_field($_GET['tab'] ?? 'all');
        if (!isset($tabs[$current])) $current = 'all';

        $args = [];
        if ($current === 'pending') $args['status'] = 'pending';
        elseif ($current === 'completed') $args['status'] = 'completed';
        elseif ($current === 'zakat') $args['type'] = 'zakat';
        elseif ($current === 'sadaqah') $args['type'] = 'sadaqah';
        $donations = KPMS_Donation::list_all($args);

        $progress = KPMS_Donation::campaign_progress();
        $pending_count = KPMS_Donation::count_pending();

        // Success messages
        $msg = sanitize_text_field($_GET['msg'] ?? '');

        // Detail view
        $detail = null;
        if (isset($_GET['view'])) {
            $detail = KPMS_Donation::get(intval($_GET['view']));
        }
        ?>
        <div class="wrap kpms-don-admin">
            <h1>KPMS Donations</h1>

            <?php if ($msg === 'confirm'): ?>
                <div class="notice notice-success is-dismissible"><p>Payment confirmed and receipt email sent.</p></div>
            <?php elseif ($msg === 'delete'): ?>
                <div class="notice notice-warning is-dismissible"><p>Donation deleted.</p></div>
            <?php endif; ?>

            <?php if ($detail): ?>
                <!-- Detail View -->
                <p><a href="<?php echo esc_url(remove_query_arg('view')); ?>">&larr; Back to list</a></p>
                <div class="kpms-don-detail-card">
                    <h2><?php echo esc_html(ucfirst($detail->donation_type)); ?> Donation #<?php echo $detail->id; ?>
                        <span class="kpms-don-status kpms-don-status-<?php echo esc_attr($detail->payment_status); ?>"><?php echo esc_html(ucfirst($detail->payment_status)); ?></span>
                    </h2>
                    <div class="kpms-don-detail-grid">
                        <div class="kpms-don-detail-row"><span class="label">Name</span><span class="value"><?php echo esc_html($detail->donor_name); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Email</span><span class="value"><a href="mailto:<?php echo esc_attr($detail->donor_email); ?>"><?php echo esc_html($detail->donor_email); ?></a></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Phone</span><span class="value"><?php echo esc_html($detail->donor_phone ?: '—'); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Amount</span><span class="value" style="font-size:20px;font-weight:700;color:#003087;">$<?php echo number_format($detail->amount, 2); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Type</span><span class="value"><?php echo esc_html(ucfirst($detail->donation_type)); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Method</span><span class="value"><?php echo esc_html(ucfirst($detail->payment_method)); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Reference</span><span class="value" style="font-family:monospace;font-weight:600;"><?php echo esc_html($detail->transaction_reference); ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">Date</span><span class="value"><?php echo esc_html(date('F j, Y g:i A', strtotime($detail->created_at))); ?></span></div>
                        <?php if ($detail->confirmed_at): ?>
                        <div class="kpms-don-detail-row"><span class="label">Confirmed</span><span class="value"><?php echo esc_html(date('F j, Y g:i A', strtotime($detail->confirmed_at))); ?></span></div>
                        <?php endif; ?>
                        <?php if ($detail->donor_message): ?>
                        <div class="kpms-don-detail-row"><span class="label">Message</span><span class="value"><?php echo nl2br(esc_html($detail->donor_message)); ?></span></div>
                        <?php endif; ?>
                        <div class="kpms-don-detail-row"><span class="label">Anonymous</span><span class="value"><?php echo $detail->is_anonymous ? 'Yes' : 'No'; ?></span></div>
                        <div class="kpms-don-detail-row"><span class="label">IP</span><span class="value"><?php echo esc_html($detail->ip_address); ?></span></div>
                    </div>
                    <div class="kpms-don-actions">
                        <?php if ($detail->payment_status === 'pending'): ?>
                        <a href="<?php echo wp_nonce_url(add_query_arg(['don_action' => 'confirm', 'don_id' => $detail->id, 'tab' => $current]), 'kpms_don_action'); ?>" class="button button-primary" style="background:#28a745;border-color:#28a745;">Confirm Payment</a>
                        <a href="<?php echo wp_nonce_url(add_query_arg(['don_action' => 'mark_failed', 'don_id' => $detail->id, 'tab' => $current]), 'kpms_don_action'); ?>" class="button" style="color:#dc3545;">Mark as Failed</a>
                        <?php endif; ?>
                        <a href="mailto:<?php echo esc_attr($detail->donor_email); ?>" class="button">Email Donor</a>
                        <a href="<?php echo wp_nonce_url(add_query_arg(['don_action' => 'delete', 'don_id' => $detail->id, 'tab' => $current]), 'kpms_don_action'); ?>" class="button" style="color:#dc3545;" onclick="return confirm('Delete this donation record?');">Delete</a>
                    </div>
                </div>

            <?php else: ?>

            <!-- Campaign Progress -->
            <div class="kpms-don-progress-admin">
                <div class="kpms-don-stats">
                    <div class="kpms-don-stat"><span class="num">$<?php echo number_format($progress['total_raised'], 0); ?></span><span class="label">Raised</span></div>
                    <div class="kpms-don-stat"><span class="num">$<?php echo number_format($progress['goal_amount'], 0); ?></span><span class="label">Goal</span></div>
                    <div class="kpms-don-stat"><span class="num"><?php echo $progress['total_donors']; ?></span><span class="label">Donors</span></div>
                    <div class="kpms-don-stat"><span class="num"><?php echo $pending_count; ?></span><span class="label">Pending</span></div>
                </div>
                <div class="kpms-don-bar-wrap">
                    <div class="kpms-don-bar" style="width:<?php echo min($progress['percent'], 100); ?>%;">
                        <span><?php echo $progress['percent']; ?>%</span>
                    </div>
                </div>
            </div>

            <!-- Tabs + Export -->
            <div class="kpms-don-tabs-row">
                <div class="kpms-don-tabs">
                    <?php foreach ($tabs as $slug => $label):
                        $active = ($current === $slug) ? ' active' : '';
                        $count_label = '';
                        if ($slug === 'pending' && $pending_count > 0) $count_label = ' <span class="kpms-don-badge">' . $pending_count . '</span>';
                    ?>
                    <a href="<?php echo esc_url(add_query_arg('tab', $slug, admin_url('admin.php?page=kpms-donations'))); ?>" class="kpms-don-tab<?php echo $active; ?>"><?php echo $label . $count_label; ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="kpms-don-export-group">
                    <a href="<?php echo wp_nonce_url(add_query_arg(['kpms_export' => 'csv', 'tab' => $current], admin_url('admin.php?page=kpms-donations')), 'kpms_don_export'); ?>" class="kpms-don-export-btn csv">Export CSV</a>
                    <a href="<?php echo wp_nonce_url(add_query_arg(['kpms_export' => 'excel', 'tab' => $current], admin_url('admin.php?page=kpms-donations')), 'kpms_don_export'); ?>" class="kpms-don-export-btn excel">Export Excel</a>
                    <a href="<?php echo wp_nonce_url(add_query_arg(['kpms_export' => 'pdf', 'tab' => $current], admin_url('admin.php?page=kpms-donations')), 'kpms_don_export'); ?>" class="kpms-don-export-btn pdf" target="_blank">Export PDF</a>
                </div>
            </div>

            <!-- Table -->
            <?php if (empty($donations)): ?>
                <div class="kpms-don-empty"><p style="font-size:40px;">&#128232;</p><p>No donations found.</p></div>
            <?php else: ?>
            <table class="kpms-don-table">
                <thead><tr>
                    <th>Date</th><th>Donor</th><th>Amount</th><th>Type</th><th>Reference</th><th>Status</th><th>Actions</th>
                </tr></thead>
                <tbody>
                <?php foreach ($donations as $d): ?>
                <tr class="<?php echo $d->payment_status === 'pending' ? 'kpms-don-row-pending' : ''; ?>">
                    <td><?php echo esc_html(date('M j, Y', strtotime($d->created_at))); ?></td>
                    <td>
                        <strong><?php echo esc_html($d->is_anonymous ? 'Anonymous' : $d->donor_name); ?></strong><br>
                        <small><?php echo esc_html($d->donor_email); ?></small>
                    </td>
                    <td style="font-weight:700;color:#003087;">$<?php echo number_format($d->amount, 2); ?></td>
                    <td><?php echo esc_html(ucfirst($d->donation_type)); ?></td>
                    <td style="font-family:monospace;font-size:12px;"><?php echo esc_html($d->transaction_reference); ?></td>
                    <td><span class="kpms-don-status kpms-don-status-<?php echo esc_attr($d->payment_status); ?>"><?php echo esc_html(ucfirst($d->payment_status)); ?></span></td>
                    <td>
                        <a href="<?php echo esc_url(add_query_arg('view', $d->id)); ?>">View</a>
                        <?php if ($d->payment_status === 'pending'): ?>
                        | <a href="<?php echo wp_nonce_url(add_query_arg(['don_action' => 'confirm', 'don_id' => $d->id, 'tab' => $current]), 'kpms_don_action'); ?>" style="color:#28a745;font-weight:600;">Confirm</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <?php endif; ?>
        </div>
        <?php
    }

    /**
     * Settings page
     */
    public static function settings_page() {
        // Save settings
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kpms_don_settings_nonce'])) {
            if (wp_verify_nonce($_POST['kpms_don_settings_nonce'], 'kpms_don_settings')) {
                update_option('kpms_don_zelle_email', sanitize_email($_POST['zelle_email'] ?? ''));
                update_option('kpms_don_zelle_phone', sanitize_text_field($_POST['zelle_phone'] ?? ''));
                update_option('kpms_don_zelle_name', sanitize_text_field($_POST['zelle_name'] ?? ''));
                update_option('kpms_don_wire_bank', sanitize_text_field($_POST['wire_bank'] ?? ''));
                update_option('kpms_don_wire_routing', sanitize_text_field($_POST['wire_routing'] ?? ''));
                update_option('kpms_don_wire_account', sanitize_text_field($_POST['wire_account'] ?? ''));
                update_option('kpms_don_wire_swift', sanitize_text_field($_POST['wire_swift'] ?? ''));
                update_option('kpms_don_wire_name', sanitize_text_field($_POST['wire_name'] ?? ''));
                update_option('kpms_don_admin_email', sanitize_email($_POST['admin_email'] ?? ''));
                update_option('kpms_don_test_mode', isset($_POST['test_mode']) ? 'yes' : 'no');

                // Update campaign goal
                global $wpdb;
                $goal = floatval($_POST['campaign_goal'] ?? 25000);
                $wpdb->update($wpdb->prefix . 'kpms_campaigns', ['goal_amount' => $goal], ['slug' => 'ramadan-2026']);

                echo '<div class="notice notice-success is-dismissible"><p>Settings saved.</p></div>';
            }
        }

        $zelle_email = get_option('kpms_don_zelle_email', '');
        $zelle_phone = get_option('kpms_don_zelle_phone', '');
        $zelle_name  = get_option('kpms_don_zelle_name', 'Kamal Public Middle School');
        $wire_bank   = get_option('kpms_don_wire_bank', '');
        $wire_routing = get_option('kpms_don_wire_routing', '');
        $wire_account = get_option('kpms_don_wire_account', '');
        $wire_swift   = get_option('kpms_don_wire_swift', '');
        $wire_name    = get_option('kpms_don_wire_name', 'Kamal Public Middle School');
        $admin_email  = get_option('kpms_don_admin_email', get_option('admin_email'));
        $test_mode    = get_option('kpms_don_test_mode', 'no');

        global $wpdb;
        $campaign = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}kpms_campaigns WHERE slug = 'ramadan-2026'");
        $goal = $campaign ? $campaign->goal_amount : 25000;
        ?>
        <div class="wrap kpms-don-admin">
            <h1>KPMS Donations — Settings</h1>
            <form method="post">
                <?php wp_nonce_field('kpms_don_settings', 'kpms_don_settings_nonce'); ?>

                <div class="kpms-don-settings-section">
                    <h2>Zelle Information</h2>
                    <p class="description">These details are shown to donors so they can send payments via Zelle.</p>
                    <table class="form-table">
                        <tr><th>Zelle Email</th><td><input type="email" name="zelle_email" value="<?php echo esc_attr($zelle_email); ?>" class="regular-text" placeholder="donate@kpms.edu.pk"></td></tr>
                        <tr><th>Zelle Phone</th><td><input type="text" name="zelle_phone" value="<?php echo esc_attr($zelle_phone); ?>" class="regular-text" placeholder="(555) 123-4567"></td></tr>
                        <tr><th>Recipient Name</th><td><input type="text" name="zelle_name" value="<?php echo esc_attr($zelle_name); ?>" class="regular-text"></td></tr>
                    </table>
                </div>

                <div class="kpms-don-settings-section">
                    <h2>Wire Transfer Details</h2>
                    <p class="description">For international donors. Leave bank name blank to hide wire option.</p>
                    <table class="form-table">
                        <tr><th>Bank Name</th><td><input type="text" name="wire_bank" value="<?php echo esc_attr($wire_bank); ?>" class="regular-text"></td></tr>
                        <tr><th>Routing Number</th><td><input type="text" name="wire_routing" value="<?php echo esc_attr($wire_routing); ?>" class="regular-text"></td></tr>
                        <tr><th>Account Number</th><td><input type="text" name="wire_account" value="<?php echo esc_attr($wire_account); ?>" class="regular-text"></td></tr>
                        <tr><th>SWIFT Code</th><td><input type="text" name="wire_swift" value="<?php echo esc_attr($wire_swift); ?>" class="regular-text" placeholder="For international transfers"></td></tr>
                        <tr><th>Account Name</th><td><input type="text" name="wire_name" value="<?php echo esc_attr($wire_name); ?>" class="regular-text"></td></tr>
                    </table>
                </div>

                <div class="kpms-don-settings-section">
                    <h2>Campaign</h2>
                    <table class="form-table">
                        <tr><th>Campaign Goal ($)</th><td><input type="number" name="campaign_goal" value="<?php echo esc_attr($goal); ?>" class="regular-text" min="100" step="100"></td></tr>
                    </table>
                </div>

                <div class="kpms-don-settings-section">
                    <h2>Notifications</h2>
                    <table class="form-table">
                        <tr><th>Admin Notification Email</th><td><input type="email" name="admin_email" value="<?php echo esc_attr($admin_email); ?>" class="regular-text"></td></tr>
                        <tr><th>Test Mode</th><td><label><input type="checkbox" name="test_mode" value="1" <?php checked($test_mode, 'yes'); ?>> Enable test mode (disables sending emails)</label></td></tr>
                    </table>
                </div>

                <?php submit_button('Save Settings'); ?>
            </form>

            <div class="kpms-don-settings-section">
                <h2>Shortcode</h2>
                <p>Add the donation form to any page using: <code>[kpms_donate]</code></p>
                <p>Add just the progress bar: <code>[kpms_campaign_progress]</code></p>
                <p>Options: <code>[kpms_donate campaign="ramadan-2026" show_progress="true" default_amount="100"]</code></p>
            </div>
        </div>
        <?php
    }
}

KPMS_Donation_Admin::init();
