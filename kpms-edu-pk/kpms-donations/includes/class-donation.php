<?php
if (!defined('ABSPATH')) exit;

class KPMS_Donation {

    private static function table() {
        global $wpdb;
        return $wpdb->prefix . 'kpms_donations';
    }

    private static function campaigns_table() {
        global $wpdb;
        return $wpdb->prefix . 'kpms_campaigns';
    }

    /**
     * Generate unique reference code: KPMS-ZAKAT-XXXXXX or KPMS-SADQ-XXXXXX
     */
    public static function generate_reference($type = 'zakat') {
        $prefix = ($type === 'zakat') ? 'KPMS-ZKT' : 'KPMS-SDQ';
        $code = $prefix . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        // Ensure uniqueness
        global $wpdb;
        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM " . self::table() . " WHERE transaction_reference = %s", $code
        ));
        if ($exists) return self::generate_reference($type);
        return $code;
    }

    /**
     * Create a new donation pledge
     */
    public static function create($data) {
        global $wpdb;
        $ref = self::generate_reference($data['donation_type'] ?? 'zakat');

        $result = $wpdb->insert(self::table(), [
            'donor_name'            => sanitize_text_field($data['donor_name']),
            'donor_email'           => sanitize_email($data['donor_email']),
            'donor_phone'           => sanitize_text_field($data['donor_phone'] ?? ''),
            'amount'                => floatval($data['amount']),
            'currency'              => 'USD',
            'donation_type'         => in_array($data['donation_type'], ['zakat', 'sadaqah']) ? $data['donation_type'] : 'zakat',
            'payment_method'        => sanitize_text_field($data['payment_method'] ?? 'zelle'),
            'payment_status'        => 'pending',
            'transaction_reference' => $ref,
            'donor_message'         => sanitize_textarea_field($data['donor_message'] ?? ''),
            'is_anonymous'          => !empty($data['is_anonymous']) ? 1 : 0,
            'ip_address'            => self::get_ip(),
            'campaign'              => sanitize_text_field($data['campaign'] ?? 'ramadan-2026'),
            'created_at'            => current_time('mysql'),
        ]);

        if ($result === false) return false;

        return [
            'id'        => $wpdb->insert_id,
            'reference' => $ref,
        ];
    }

    /**
     * Get donation by ID
     */
    public static function get($id) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM " . self::table() . " WHERE id = %d", intval($id)));
    }

    /**
     * Get donation by reference code
     */
    public static function get_by_reference($ref) {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare("SELECT * FROM " . self::table() . " WHERE transaction_reference = %s", $ref));
    }

    /**
     * Update donation status
     */
    public static function update_status($id, $status) {
        global $wpdb;
        $data = ['payment_status' => $status];
        if ($status === 'completed') {
            $data['confirmed_at'] = current_time('mysql');
        }
        return $wpdb->update(self::table(), $data, ['id' => intval($id)]);
    }

    /**
     * Delete donation
     */
    public static function delete($id) {
        global $wpdb;
        return $wpdb->delete(self::table(), ['id' => intval($id)]);
    }

    /**
     * List donations with optional filters
     */
    public static function list_all($args = []) {
        global $wpdb;
        $table = self::table();
        $where = '1=1';
        $params = [];

        if (!empty($args['status'])) {
            $where .= ' AND payment_status = %s';
            $params[] = $args['status'];
        }
        if (!empty($args['type'])) {
            $where .= ' AND donation_type = %s';
            $params[] = $args['type'];
        }
        if (!empty($args['campaign'])) {
            $where .= ' AND campaign = %s';
            $params[] = $args['campaign'];
        }

        $limit = intval($args['limit'] ?? 200);
        $orderby = ($args['orderby'] ?? 'created_at') === 'amount' ? 'amount' : 'created_at';
        $order = ($args['order'] ?? 'DESC') === 'ASC' ? 'ASC' : 'DESC';

        $sql = "SELECT * FROM $table WHERE $where ORDER BY $orderby $order LIMIT $limit";
        if (!empty($params)) {
            $sql = $wpdb->prepare($sql, ...$params);
        }
        return $wpdb->get_results($sql);
    }

    /**
     * Get campaign progress
     */
    public static function campaign_progress($campaign = 'ramadan-2026') {
        global $wpdb;
        $table = self::table();
        $ctable = self::campaigns_table();

        $stats = $wpdb->get_row($wpdb->prepare(
            "SELECT
                COUNT(*) as total_donors,
                COALESCE(SUM(amount), 0) as total_raised,
                COALESCE(SUM(CASE WHEN donation_type='zakat' THEN amount ELSE 0 END), 0) as zakat_total,
                COALESCE(SUM(CASE WHEN donation_type='sadaqah' THEN amount ELSE 0 END), 0) as sadaqah_total
            FROM $table
            WHERE campaign = %s AND payment_status = 'completed'",
            $campaign
        ));

        $camp = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $ctable WHERE slug = %s", $campaign
        ));

        return [
            'total_raised'  => floatval($stats->total_raised ?? 0),
            'total_donors'  => intval($stats->total_donors ?? 0),
            'zakat_total'   => floatval($stats->zakat_total ?? 0),
            'sadaqah_total' => floatval($stats->sadaqah_total ?? 0),
            'goal_amount'   => floatval($camp->goal_amount ?? 25000),
            'campaign_title'=> $camp->title ?? 'Ramadan 2026 Campaign',
            'percent'       => ($camp && $camp->goal_amount > 0) ? round(($stats->total_raised / $camp->goal_amount) * 100, 1) : 0,
        ];
    }

    /**
     * Count pending donations
     */
    public static function count_pending() {
        global $wpdb;
        return (int) $wpdb->get_var("SELECT COUNT(*) FROM " . self::table() . " WHERE payment_status = 'pending'");
    }

    /**
     * Rate limiting check
     */
    public static function is_rate_limited($ip) {
        global $wpdb;
        $count = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM " . self::table() . " WHERE ip_address = %s AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)",
            $ip
        ));
        return $count >= 10;
    }

    private static function get_ip() {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return sanitize_text_field(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
        }
        return sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
    }
}
