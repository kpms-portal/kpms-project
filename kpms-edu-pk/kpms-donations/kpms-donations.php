<?php
/**
 * Plugin Name: KPMS Donations
 * Description: Zakat & Sadaqah donation system for Kamal Public Middle School with Zelle/wire transfer support.
 * Version: 1.0.0
 * Author: KPMS
 * Text Domain: kpms-donations
 */

if (!defined('ABSPATH')) exit;

define('KPMS_DON_VERSION', '1.0.0');
define('KPMS_DON_PATH', plugin_dir_path(__FILE__));
define('KPMS_DON_URL', plugin_dir_url(__FILE__));

// Load classes
require_once KPMS_DON_PATH . 'includes/class-donation.php';
require_once KPMS_DON_PATH . 'includes/class-email.php';
require_once KPMS_DON_PATH . 'includes/class-api.php';
require_once KPMS_DON_PATH . 'includes/class-admin.php';

// ─── Activation: create DB tables ───
register_activation_hook(__FILE__, 'kpms_don_activate');

function kpms_don_activate() {
    global $wpdb;
    $charset = $wpdb->get_charset_collate();

    $donations_table = $wpdb->prefix . 'kpms_donations';
    $campaigns_table = $wpdb->prefix . 'kpms_campaigns';

    $sql_donations = "CREATE TABLE $donations_table (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        donor_name varchar(255) NOT NULL DEFAULT '',
        donor_email varchar(255) NOT NULL DEFAULT '',
        donor_phone varchar(50) NOT NULL DEFAULT '',
        amount decimal(10,2) NOT NULL,
        currency varchar(3) NOT NULL DEFAULT 'USD',
        donation_type varchar(20) NOT NULL DEFAULT 'zakat',
        payment_method varchar(20) NOT NULL DEFAULT 'zelle',
        payment_status varchar(20) NOT NULL DEFAULT 'pending',
        transaction_reference varchar(100) NOT NULL DEFAULT '',
        is_recurring tinyint(1) NOT NULL DEFAULT 0,
        donor_message text NOT NULL,
        is_anonymous tinyint(1) NOT NULL DEFAULT 0,
        ip_address varchar(45) NOT NULL DEFAULT '',
        campaign varchar(100) NOT NULL DEFAULT 'ramadan-2026',
        created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        confirmed_at datetime DEFAULT NULL,
        PRIMARY KEY  (id),
        KEY idx_email (donor_email),
        KEY idx_status (payment_status),
        KEY idx_campaign (campaign),
        KEY idx_type (donation_type),
        KEY idx_reference (transaction_reference)
    ) $charset;";

    $sql_campaigns = "CREATE TABLE $campaigns_table (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        slug varchar(100) NOT NULL DEFAULT '',
        title varchar(255) NOT NULL DEFAULT '',
        goal_amount decimal(10,2) NOT NULL DEFAULT 0,
        start_date date DEFAULT NULL,
        end_date date DEFAULT NULL,
        is_active tinyint(1) NOT NULL DEFAULT 1,
        created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id),
        UNIQUE KEY slug (slug)
    ) $charset;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql_donations);
    dbDelta($sql_campaigns);

    // Seed default campaign if none exists
    $exists = $wpdb->get_var("SELECT COUNT(*) FROM $campaigns_table WHERE slug = 'ramadan-2026'");
    if (!$exists) {
        $wpdb->insert($campaigns_table, [
            'slug'        => 'ramadan-2026',
            'title'       => 'Ramadan 2026 Zakat Campaign',
            'goal_amount' => 25000.00,
            'start_date'  => '2026-02-17',
            'end_date'    => '2026-03-19',
            'is_active'   => 1,
            'created_at'  => current_time('mysql'),
        ]);
    }

    // Default settings
    if (!get_option('kpms_don_zelle_email')) {
        update_option('kpms_don_zelle_email', '');
    }
    if (!get_option('kpms_don_admin_email')) {
        update_option('kpms_don_admin_email', get_option('admin_email'));
    }

    update_option('kpms_don_db_version', KPMS_DON_VERSION);
}

// Safety net: ensure tables exist
add_action('admin_init', function() {
    if (get_option('kpms_don_db_version') !== KPMS_DON_VERSION) {
        kpms_don_activate();
    }
});

// ─── Enqueue frontend assets ───
add_action('wp_enqueue_scripts', function() {
    global $post;
    if (!is_a($post, 'WP_Post')) return;
    if (!has_shortcode($post->post_content, 'kpms_donate') && !has_shortcode($post->post_content, 'kpms_campaign_progress')) return;

    wp_enqueue_style('kpms-donate-css', KPMS_DON_URL . 'public/css/donate.css', [], KPMS_DON_VERSION);
    wp_enqueue_script('kpms-donate-js', KPMS_DON_URL . 'public/js/donate.js', [], KPMS_DON_VERSION, true);
    wp_localize_script('kpms-donate-js', 'kpmsDonate', [
        'api'   => esc_url_raw(rest_url('kpms/v1/')),
        'nonce' => wp_create_nonce('wp_rest'),
    ]);
});

// ─── Shortcodes ───
add_shortcode('kpms_donate', 'kpms_donate_shortcode');
add_shortcode('kpms_campaign_progress', 'kpms_progress_shortcode');

function kpms_donate_shortcode($atts) {
    $atts = shortcode_atts([
        'campaign'       => 'ramadan-2026',
        'show_progress'  => 'true',
        'default_amount' => '100',
    ], $atts);

    ob_start();
    ?>
    <div id="kpms-donate-app" data-campaign="<?php echo esc_attr($atts['campaign']); ?>" data-default="<?php echo esc_attr($atts['default_amount']); ?>">

        <?php if ($atts['show_progress'] === 'true'): ?>
        <div class="kpms-don-progress-wrap" id="kpms-progress-bar"></div>
        <?php endif; ?>

        <!-- Step 1: Amount -->
        <div class="kpms-don-step" id="kpms-step-amount">
            <h3 class="kpms-don-heading">Choose Your Donation Amount</h3>
            <div class="kpms-don-amounts">
                <button class="kpms-don-amt" data-amount="50">$50</button>
                <button class="kpms-don-amt" data-amount="100">$100</button>
                <button class="kpms-don-amt" data-amount="150">$150</button>
                <button class="kpms-don-amt" data-amount="200">$200</button>
                <button class="kpms-don-amt" data-amount="500">$500</button>
                <button class="kpms-don-amt" data-amount="1000">$1,000</button>
            </div>
            <div class="kpms-don-custom">
                <label>Custom Amount</label>
                <div class="kpms-don-input-wrap">
                    <span class="kpms-don-dollar">$</span>
                    <input type="number" id="kpms-custom-amount" min="1" max="100000" placeholder="Enter amount">
                </div>
            </div>

            <div class="kpms-don-type-toggle">
                <label class="kpms-don-type active" data-type="zakat">
                    <input type="radio" name="kpms_don_type" value="zakat" checked> Zakat
                </label>
                <label class="kpms-don-type" data-type="sadaqah">
                    <input type="radio" name="kpms_don_type" value="sadaqah"> Sadaqah
                </label>
            </div>

            <button class="kpms-don-btn" id="kpms-next-info" disabled>Continue</button>
        </div>

        <!-- Step 2: Donor Info -->
        <div class="kpms-don-step" id="kpms-step-info" style="display:none;">
            <h3 class="kpms-don-heading">Your Information</h3>
            <div class="kpms-don-field">
                <label>Full Name <span class="req">*</span></label>
                <input type="text" id="kpms-donor-name" required>
            </div>
            <div class="kpms-don-field">
                <label>Email <span class="req">*</span></label>
                <input type="email" id="kpms-donor-email" required>
            </div>
            <div class="kpms-don-field">
                <label>Phone</label>
                <input type="tel" id="kpms-donor-phone">
            </div>
            <div class="kpms-don-field">
                <label>Message (optional)</label>
                <textarea id="kpms-donor-message" rows="3" placeholder="Leave a message of support..."></textarea>
            </div>
            <label class="kpms-don-check">
                <input type="checkbox" id="kpms-anonymous"> Make my donation anonymous
            </label>
            <div class="kpms-don-btn-row">
                <button class="kpms-don-btn secondary" id="kpms-back-amount">Back</button>
                <button class="kpms-don-btn" id="kpms-submit-pledge">Donate Now</button>
            </div>
        </div>

        <!-- Step 3: Success / Instructions -->
        <div class="kpms-don-step" id="kpms-step-success" style="display:none;">
            <div class="kpms-don-success-icon">&#10003;</div>
            <h3 class="kpms-don-heading">JazakAllah Khair!</h3>
            <p class="kpms-don-sub">Your donation pledge of <strong id="kpms-pledge-amount"></strong> (<span id="kpms-pledge-type"></span>) has been recorded.</p>

            <div class="kpms-don-instructions">
                <h4>Send Your Payment</h4>
                <div class="kpms-don-method" id="kpms-zelle-info"></div>
                <div class="kpms-don-method" id="kpms-wire-info"></div>
                <div class="kpms-don-ref">
                    <strong>Reference Code:</strong>
                    <span id="kpms-ref-code" class="kpms-don-ref-code"></span>
                    <small>Include this in your payment memo</small>
                </div>
            </div>
            <p class="kpms-don-note">You will receive an email confirmation once your payment has been verified. 100% of your donation goes directly to educating children at KPMS.</p>
        </div>

        <!-- Error -->
        <div class="kpms-don-error" id="kpms-don-error" style="display:none;"></div>
    </div>
    <?php
    return ob_get_clean();
}

function kpms_progress_shortcode($atts) {
    $atts = shortcode_atts(['campaign' => 'ramadan-2026'], $atts);
    return '<div class="kpms-don-progress-wrap" id="kpms-progress-bar" data-campaign="' . esc_attr($atts['campaign']) . '"></div>';
}
