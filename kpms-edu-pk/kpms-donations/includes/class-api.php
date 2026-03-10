<?php
if (!defined('ABSPATH')) exit;

class KPMS_Donation_API {

    public static function init() {
        add_action('rest_api_init', [__CLASS__, 'register_routes']);
    }

    public static function register_routes() {
        $ns = 'kpms/v1';

        register_rest_route($ns, '/donate/pledge', [
            'methods'             => 'POST',
            'callback'            => [__CLASS__, 'create_pledge'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($ns, '/campaign/progress', [
            'methods'             => 'GET',
            'callback'            => [__CLASS__, 'get_progress'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route($ns, '/donate/settings', [
            'methods'             => 'GET',
            'callback'            => [__CLASS__, 'get_public_settings'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * POST /wp-json/kpms/v1/donate/pledge
     */
    public static function create_pledge($request) {
        // Verify nonce
        $nonce = $request->get_header('X-WP-Nonce');
        if (!$nonce || !wp_verify_nonce($nonce, 'wp_rest')) {
            return new WP_Error('invalid_nonce', 'Security check failed.', ['status' => 403]);
        }

        // Rate limiting
        $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
        if (KPMS_Donation::is_rate_limited($ip)) {
            return new WP_Error('rate_limited', 'Too many requests. Please try again later.', ['status' => 429]);
        }

        $params = $request->get_json_params();

        // Validate required fields
        $name  = sanitize_text_field($params['donor_name'] ?? '');
        $email = sanitize_email($params['donor_email'] ?? '');
        $amount = floatval($params['amount'] ?? 0);

        if (empty($name)) {
            return new WP_Error('missing_name', 'Please enter your name.', ['status' => 400]);
        }
        if (!is_email($email)) {
            return new WP_Error('invalid_email', 'Please enter a valid email address.', ['status' => 400]);
        }
        if ($amount < 1 || $amount > 100000) {
            return new WP_Error('invalid_amount', 'Amount must be between $1 and $100,000.', ['status' => 400]);
        }

        // Create the donation pledge
        $result = KPMS_Donation::create([
            'donor_name'     => $name,
            'donor_email'    => $email,
            'donor_phone'    => sanitize_text_field($params['donor_phone'] ?? ''),
            'amount'         => $amount,
            'donation_type'  => in_array($params['donation_type'] ?? '', ['zakat', 'sadaqah']) ? $params['donation_type'] : 'zakat',
            'payment_method' => 'zelle',
            'donor_message'  => sanitize_textarea_field($params['donor_message'] ?? ''),
            'is_anonymous'   => !empty($params['is_anonymous']),
            'campaign'       => sanitize_text_field($params['campaign'] ?? 'ramadan-2026'),
        ]);

        if (!$result) {
            return new WP_Error('db_error', 'Failed to record donation. Please try again.', ['status' => 500]);
        }

        // Send admin notification
        $donation = KPMS_Donation::get($result['id']);
        if ($donation) {
            KPMS_Email::send_admin_notification($donation);
            KPMS_Email::send_pledge_confirmation($donation);
        }

        // Return payment instructions
        return rest_ensure_response([
            'success'   => true,
            'reference' => $result['reference'],
            'zelle'     => self::get_zelle_info(),
            'wire'      => self::get_wire_info(),
        ]);
    }

    /**
     * GET /wp-json/kpms/v1/campaign/progress
     */
    public static function get_progress($request) {
        $campaign = sanitize_text_field($request->get_param('campaign') ?? 'ramadan-2026');
        return rest_ensure_response(KPMS_Donation::campaign_progress($campaign));
    }

    /**
     * GET /wp-json/kpms/v1/donate/settings (public-safe settings only)
     */
    public static function get_public_settings($request) {
        return rest_ensure_response([
            'zelle' => self::get_zelle_info(),
            'wire'  => self::get_wire_info(),
        ]);
    }

    private static function get_zelle_info() {
        $email = get_option('kpms_don_zelle_email', '');
        $phone = get_option('kpms_don_zelle_phone', '');
        $name  = get_option('kpms_don_zelle_name', 'Kamal Public Middle School');
        if (empty($email) && empty($phone)) return null;
        return [
            'email' => $email,
            'phone' => $phone,
            'name'  => $name,
        ];
    }

    private static function get_wire_info() {
        $bank = get_option('kpms_don_wire_bank', '');
        if (empty($bank)) return null;
        return [
            'bank_name'      => $bank,
            'routing_number' => get_option('kpms_don_wire_routing', ''),
            'account_number' => get_option('kpms_don_wire_account', ''),
            'swift_code'     => get_option('kpms_don_wire_swift', ''),
            'account_name'   => get_option('kpms_don_wire_name', 'Kamal Public Middle School'),
        ];
    }
}

KPMS_Donation_API::init();
