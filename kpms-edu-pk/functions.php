<?php
/**
 * KPMS Theme - Functions
 * Theme for Kamal Public Middle School (kpms.edu.pk)
 */

// Register all KPMS page templates
add_filter('theme_page_templates', function($templates) {
    $templates['kpms-homepage.php'] = 'KPMS - Homepage';
    $templates['page-contact.php'] = 'KPMS - Contact Us';
    $templates['page-enrollment.php'] = 'KPMS - Enrollment';
    $templates['page-staff-directory.php'] = 'KPMS - Staff Directory';
    $templates['page-calendar.php'] = 'KPMS - School Calendar';
    $templates['page-parent-portal.php'] = 'KPMS - Parent Portal';
    $templates['page-mission-vision.php'] = 'KPMS - Mission & Vision';
    $templates['page-philosophy.php'] = 'KPMS - School Philosophy';
    $templates['page-news.php'] = 'KPMS - News';
    $templates['page-grade-levels.php'] = 'KPMS - Grade Levels';
    $templates['page-campus-visit.php'] = 'KPMS - Campus Visit';
    $templates['page-campus.php'] = 'KPMS - Our Campus';
    $templates['page-montessori.php'] = 'KPMS - Montessori Program';
    $templates['page-primary-education.php'] = 'KPMS - Primary Education';
    $templates['page-tuition.php'] = 'KPMS - Tuition & Tutoring';
    $templates['page-apply-online.php'] = 'KPMS - Apply Online';
    $templates['page-prospectus.php'] = 'KPMS - View Prospectus';
    $templates['page-schedule-tour.php'] = 'KPMS - Schedule a Tour';
    $templates['page-student-resources.php'] = 'KPMS - Student Resources';
    $templates['page-student-games.php'] = 'KPMS - Learning Games';
    $templates['page-careers.php'] = 'KPMS - Careers';
    $templates['page-donate.php'] = 'KPMS - Donate';
    return $templates;
});

// Load templates from theme directory
add_filter('template_include', function($template) {
    if (is_page()) {
        $custom = get_page_template_slug();
        $kpms_templates = array(
            'kpms-homepage.php',
            'page-contact.php',
            'page-enrollment.php',
            'page-staff-directory.php',
            'page-calendar.php',
            'page-parent-portal.php',
            'page-mission-vision.php',
            'page-philosophy.php',
            'page-news.php',
            'page-grade-levels.php',
            'page-campus-visit.php',
            'page-campus.php',
            'page-montessori.php',
            'page-primary-education.php',
            'page-tuition.php',
            'page-apply-online.php',
            'page-prospectus.php',
            'page-schedule-tour.php',
            'page-student-resources.php',
            'page-student-games.php',
            'page-careers.php',
            'page-donate.php',
        );
        if (in_array($custom, $kpms_templates, true)) {
            $file = get_stylesheet_directory() . '/' . $custom;
            if (file_exists($file)) return $file;
        }
    }
    return $template;
});

// Add theme support
add_action('after_setup_theme', function() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
});

// Google Tag Manager (head)
add_action('wp_head', function() {
    ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WHZTGGWJ');</script>
    <!-- End Google Tag Manager -->
    <?php
}, 1);

// Google Tag Manager (body noscript)
add_action('wp_body_open', function() {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHZTGGWJ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
});

// ============================================================
// TEACHER ROLE REGISTRATION
// ============================================================

add_action('after_setup_theme', function() {
    $role = get_role('kpms_teacher');
    if (!$role) {
        add_role('kpms_teacher', 'KPMS Teacher', [
            'read'                 => true,
            'edit_pages'           => true,
            'edit_others_pages'    => true,
            'edit_published_pages' => true,
            'upload_files'         => true,
        ]);
    } else {
        // Ensure existing role has the needed capabilities
        $role->add_cap('edit_others_pages');
        $role->add_cap('edit_published_pages');
    }
});

// ============================================================
// FORM HANDLING SYSTEM
// ============================================================

// Include form handler
require_once get_stylesheet_directory() . '/form-handler.php';

// Register AJAX hooks (logged-in and visitors)
add_action('wp_ajax_kpms_form_submit', 'kpms_handle_form_submit');
add_action('wp_ajax_nopriv_kpms_form_submit', 'kpms_handle_form_submit');

// Create database tables on theme activation
add_action('after_switch_theme', 'kpms_create_tables');

// Also create on admin_init as a safety net
add_action('admin_init', function() {
    if (get_option('kpms_db_version') !== '2.3') {
        kpms_create_tables();
    }
});

function kpms_create_tables() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Submissions table
    $t1 = $wpdb->prefix . 'kpms_submissions';
    dbDelta("CREATE TABLE $t1 (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        form_type varchar(30) NOT NULL DEFAULT '',
        name varchar(255) NOT NULL DEFAULT '',
        email varchar(255) NOT NULL DEFAULT '',
        phone varchar(50) NOT NULL DEFAULT '',
        message text NOT NULL,
        data_json longtext NOT NULL,
        ip_address varchar(45) NOT NULL DEFAULT '',
        submitted_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        status varchar(20) NOT NULL DEFAULT 'new',
        read_flag tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY  (id),
        KEY form_type (form_type),
        KEY submitted_at (submitted_at),
        KEY status (status)
    ) $charset_collate;");

    // Announcements table
    $t2 = $wpdb->prefix . 'kpms_announcements';
    dbDelta("CREATE TABLE $t2 (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        author_id bigint(20) unsigned NOT NULL,
        title varchar(255) NOT NULL DEFAULT '',
        message text NOT NULL,
        priority varchar(20) NOT NULL DEFAULT 'normal',
        expires_at date DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id),
        KEY author_id (author_id),
        KEY created_at (created_at)
    ) $charset_collate;");

    // Events table
    $t3 = $wpdb->prefix . 'kpms_events';
    dbDelta("CREATE TABLE $t3 (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        author_id bigint(20) unsigned NOT NULL,
        event_name varchar(255) NOT NULL DEFAULT '',
        event_date date NOT NULL,
        event_time varchar(10) NOT NULL DEFAULT '',
        location varchar(255) NOT NULL DEFAULT '',
        description text NOT NULL,
        created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id),
        KEY event_date (event_date),
        KEY author_id (author_id)
    ) $charset_collate;");

    // Staff profiles table
    $t4 = $wpdb->prefix . 'kpms_staff';
    dbDelta("CREATE TABLE $t4 (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned DEFAULT NULL,
        name varchar(255) NOT NULL DEFAULT '',
        title varchar(255) NOT NULL DEFAULT '',
        photo_url varchar(500) NOT NULL DEFAULT '',
        bio text NOT NULL,
        quote varchar(500) NOT NULL DEFAULT '',
        department varchar(100) NOT NULL DEFAULT '',
        qualifications text NOT NULL,
        category varchar(20) NOT NULL DEFAULT 'teaching',
        display_order int NOT NULL DEFAULT 0,
        circle_color varchar(7) NOT NULL DEFAULT '#003087',
        featured_on_homepage tinyint(1) NOT NULL DEFAULT 0,
        email varchar(255) NOT NULL DEFAULT '',
        phone varchar(50) NOT NULL DEFAULT '',
        is_active tinyint(1) NOT NULL DEFAULT 1,
        updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id),
        KEY user_id (user_id),
        KEY category (category),
        KEY is_active (is_active),
        KEY featured_on_homepage (featured_on_homepage)
    ) $charset_collate;");

    update_option('kpms_db_version', '2.3');

    // Seed hardcoded staff if table is empty or missing category data
    kpms_seed_staff_data();
}

/**
 * Helper: get initials from a name, skipping honorifics.
 */
function kpms_get_initials($name) {
    $parts = explode(' ', trim($name));
    $initials = '';
    $skip = ['mr', 'mrs', 'miss', 'ms', 'dr'];
    foreach ($parts as $part) {
        if (in_array(strtolower(rtrim($part, '.')), $skip)) continue;
        if (!empty($part)) $initials .= strtoupper(mb_substr(trim($part), 0, 1));
    }
    return mb_substr($initials, 0, 2);
}

/**
 * Seed hardcoded staff into kpms_staff table (runs once on upgrade).
 */
function kpms_seed_staff_data() {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_staff';

    // Only seed if no rows have a category set
    $has_categorized = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE category != '' AND category != 'teaching'");
    if ($has_categorized > 0) return;

    // Update any existing rows that have user_id but no name (like Zubair Hasan)
    $existing = $wpdb->get_results("SELECT s.id, s.user_id, s.name FROM $table s");
    foreach ($existing as $row) {
        if (empty($row->name) && $row->user_id > 0) {
            $user = get_userdata($row->user_id);
            if ($user) {
                $wpdb->update($table, ['name' => $user->display_name], ['id' => $row->id]);
            }
        }
    }

    $now = current_time('mysql');
    $seed = [
        // Leadership
        ['Mr. Kamal Ahmed', 'Founder & Principal', 'Administration', 'leadership', 'Founded KPMS in 1985 with a vision to provide quality education in Abbottabad. Over 40 years of educational leadership.', '#FFD100', 1],
        ['Mrs. Saima Akhtar', 'Vice Principal', 'Administration', 'leadership', 'Oversees academic programs and teacher development. 15 years in education with a focus on early childhood learning.', '#003087', 2],
        ['Mr. Nasir Khan', 'Head of Administration', 'Administration', 'leadership', 'Manages operations, admissions, and parent relations. Ensures smooth day-to-day running of the school.', '#E8443A', 3],
        // Teaching Faculty
        ['Miss Fatima Ali', 'English & Reading', 'English & Reading', 'teaching', 'Teaches English language and reading comprehension for Grades 3-5. Passionate about building a love of literature.', '#00B4D8', 1],
        ['Mr. Adeel Hussain', 'Mathematics', 'Mathematics', 'teaching', 'Makes math fun and accessible. Uses hands-on activities and real-world problems to engage young learners.', '#FFD100', 2],
        ['Mrs. Zainab Bibi', 'Urdu & Islamiyat', 'Urdu & Islamiyat', 'teaching', 'Nurtures students\' Urdu literacy and Islamic education with a warm, story-based approach.', '#E8443A', 3],
        ['Mr. Rashid Khan', 'Science & Nature Studies', 'Science & Nature Studies', 'teaching', 'Brings science alive through experiments and outdoor exploration. Leads the school garden project.', '#003087', 4],
        ['Miss Hina Shah', 'Art & Creative Expression', 'Art & Creative Expression', 'teaching', 'Guides students through painting, sculpture, and craft. Organizes the annual Spring Art Exhibition.', '#003087', 5],
        ['Mr. Tariq Ahmed', 'Physical Education', 'Physical Education', 'teaching', 'Coaches sports day events and daily exercise. Believes every child should enjoy movement and teamwork.', '#FFD100', 6],
        ['Mrs. Nadia Parveen', 'Pre-K & Kindergarten', 'Pre-K & Kindergarten', 'teaching', 'Creates a nurturing environment for our youngest students. Specializes in early childhood development and play-based learning.', '#E8443A', 7],
        ['Mr. Imran Qureshi', 'Computer Studies', 'Computer Studies', 'teaching', 'Introduces students to digital literacy, basic coding, and responsible technology use.', '#003087', 8],
        // Support Staff
        ['Mr. Akbar Mahmood', 'School Counselor', 'Counseling', 'support', 'Provides pastoral care and emotional support. Available for students and parents throughout the week.', '#003087', 1],
        ['Mrs. Shamim Noor', 'School Nurse', 'Health Services', 'support', 'Manages student health records, first aid, and coordinates with parents on medical needs.', '#0A8F6C', 2],
        ['Mr. Waqar Ali', 'Facilities Manager', 'Facilities', 'support', 'Keeps our campus safe, clean, and beautiful. Manages maintenance, security, and grounds.', '#8896a6', 3],
    ];

    foreach ($seed as $s) {
        // Check if name already exists
        $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table WHERE name = %s", $s[0]));
        if ($exists > 0) continue;

        $wpdb->insert($table, [
            'name'          => $s[0],
            'title'         => $s[1],
            'department'    => $s[2],
            'category'      => $s[3],
            'bio'           => $s[4],
            'circle_color'  => $s[5],
            'display_order' => $s[6],
            'is_active'     => 1,
            'updated_at'    => $now,
        ]);
    }
}

// ============================================================
// EXPORT HANDLERS (must run before any output)
// ============================================================

add_action('admin_init', 'kpms_handle_exports');

function kpms_handle_exports() {
    if (!current_user_can('manage_options')) return;
    if (!isset($_GET['page']) || $_GET['page'] !== 'kpms-submissions') return;

    // CSV Export
    if (isset($_GET['export_kpms']) && $_GET['export_kpms'] === 'csv') {
        if (!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_export')) return;
        $rows = kpms_get_export_rows();
        $tab = sanitize_text_field($_GET['tab'] ?? 'all');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=kpms-submissions-' . $tab . '-' . date('Y-m-d') . '.csv');
        header('Pragma: no-cache');
        header('Expires: 0');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Date', 'Type', 'Name', 'Email', 'Phone', 'Subject/Position', 'Message/Details', 'Status']);
        foreach ($rows as $row) {
            fputcsv($out, kpms_format_export_row($row));
        }
        fclose($out);
        exit;
    }

    // Excel Export
    if (isset($_GET['export_kpms']) && $_GET['export_kpms'] === 'excel') {
        if (!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_export')) return;
        $rows = kpms_get_export_rows();
        $tab = sanitize_text_field($_GET['tab'] ?? 'all');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=kpms-submissions-' . $tab . '-' . date('Y-m-d') . '.xls');
        header('Pragma: no-cache');
        header('Expires: 0');
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        echo '<head><meta charset="utf-8"><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Submissions</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head>';
        echo '<body><table border="1">';
        echo '<tr><th style="font-weight:bold;background:#003087;color:#fff;">Date</th><th style="font-weight:bold;background:#003087;color:#fff;">Type</th><th style="font-weight:bold;background:#003087;color:#fff;">Name</th><th style="font-weight:bold;background:#003087;color:#fff;">Email</th><th style="font-weight:bold;background:#003087;color:#fff;">Phone</th><th style="font-weight:bold;background:#003087;color:#fff;">Subject/Position</th><th style="font-weight:bold;background:#003087;color:#fff;">Message/Details</th><th style="font-weight:bold;background:#003087;color:#fff;">Status</th></tr>';
        foreach ($rows as $row) {
            $d = kpms_format_export_row($row);
            echo '<tr>';
            foreach ($d as $cell) {
                echo '<td>' . htmlspecialchars($cell, ENT_QUOTES, 'UTF-8') . '</td>';
            }
            echo '</tr>';
        }
        echo '</table></body></html>';
        exit;
    }

    // PDF (printable HTML page)
    if (isset($_GET['export_kpms']) && $_GET['export_kpms'] === 'pdf') {
        if (!wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_export')) return;
        $rows = kpms_get_export_rows();
        $tab = sanitize_text_field($_GET['tab'] ?? 'all');
        $date = date('F j, Y');
        $logo_url = home_url('/wp-content/uploads/2026/02/Kamal-Public-School-2.png');
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>KPMS Submissions Report - <?php echo $date; ?></title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; padding: 30px; font-size: 12px; }
    .report-header { text-align: center; margin-bottom: 24px; border-bottom: 3px solid #003087; padding-bottom: 16px; }
    .report-header img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-bottom: 8px; }
    .report-header h1 { font-size: 20px; color: #003087; margin: 4px 0; }
    .report-header p { font-size: 12px; color: #666; }
    .report-meta { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 11px; color: #555; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    th { background: #003087; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
    td { padding: 6px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #f8f9fa; }
    .status-new { color: #856404; font-weight: 600; }
    .status-read { color: #155724; font-weight: 600; }
    .status-replied { color: #004085; font-weight: 600; }
    .no-print { text-align: center; margin-bottom: 20px; }
    .no-print button { padding: 10px 30px; background: #003087; color: #fff; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; margin: 0 6px; }
    .no-print button.close-btn { background: #dc3545; }
    @media print {
        .no-print { display: none; }
        body { padding: 10px; }
        th { background: #003087 !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        tr:nth-child(even) td { background: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
</head>
<body>
<div class="no-print">
    <button onclick="window.print()">Print / Save as PDF</button>
    <button class="close-btn" onclick="window.close()">Close</button>
</div>
<div class="report-header">
    <img src="<?php echo esc_url($logo_url); ?>" alt="KPMS Logo">
    <h1>Kamal Public Middle School</h1>
    <p>KPMS Submissions Report &mdash; <?php echo esc_html(ucfirst($tab)); ?> &mdash; <?php echo $date; ?></p>
</div>
<div class="report-meta">
    <span>Total Records: <?php echo count($rows); ?></span>
    <span>Generated: <?php echo date('M j, Y g:i A'); ?></span>
</div>
<table>
<thead><tr><th>Date</th><th>Type</th><th>Name</th><th>Email</th><th>Phone</th><th>Subject/Position</th><th>Message/Details</th><th>Status</th></tr></thead>
<tbody>
<?php foreach ($rows as $row):
    $d = kpms_format_export_row($row);
    $sc = 'status-' . esc_attr($row->status);
?>
<tr>
    <td><?php echo esc_html($d[0]); ?></td>
    <td><?php echo esc_html($d[1]); ?></td>
    <td><?php echo esc_html($d[2]); ?></td>
    <td><?php echo esc_html($d[3]); ?></td>
    <td><?php echo esc_html($d[4]); ?></td>
    <td><?php echo esc_html($d[5]); ?></td>
    <td><?php echo esc_html(mb_strimwidth($d[6], 0, 120, '...')); ?></td>
    <td class="<?php echo $sc; ?>"><?php echo esc_html(ucfirst($d[7])); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<script>window.onload=function(){window.print();};</script>
</body>
</html>
        <?php
        exit;
    }
}

/**
 * Get export rows filtered by current tab
 */
function kpms_get_export_rows() {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_submissions';
    $tab = sanitize_text_field($_GET['tab'] ?? 'all');
    $where = ($tab !== 'all') ? $wpdb->prepare("WHERE form_type = %s", $tab) : '';
    return $wpdb->get_results("SELECT * FROM $table $where ORDER BY submitted_at DESC");
}

/**
 * Format a submission row for export
 */
function kpms_format_export_row($row) {
    $json = json_decode($row->data_json, true);
    if (!is_array($json)) $json = [];

    // Extract subject/position based on form type
    $subject = '';
    if ($row->form_type === 'contact') {
        $subject = $json['subject'] ?? '';
    } elseif ($row->form_type === 'application') {
        $subject = 'Grade: ' . ($json['grade_applying_for'] ?? 'N/A');
    } elseif ($row->form_type === 'tour') {
        $subject = ($json['preferred_date'] ?? '') . ' ' . ($json['preferred_time'] ?? '');
    } elseif ($row->form_type === 'career') {
        $subject = $json['position'] ?? ($json['position_interest'] ?? '');
    }

    // Build details string from JSON data
    $details = $row->message;
    if (empty($details)) {
        $skip = ['name', 'email', 'phone', 'full_name', 'parent_email', 'parent_phone', 'subject', 'message', 'form_type', 'nonce'];
        $parts = [];
        foreach ($json as $k => $v) {
            if (in_array($k, $skip) || empty($v)) continue;
            $parts[] = ucwords(str_replace('_', ' ', $k)) . ': ' . $v;
        }
        $details = implode('; ', $parts);
    }

    return [
        date('Y-m-d H:i', strtotime($row->submitted_at)),
        ucfirst($row->form_type),
        $row->name,
        $row->email,
        $row->phone,
        $subject,
        $details,
        $row->status,
    ];
}

// ============================================================
// ADMIN SUBMISSIONS VIEWER
// ============================================================

require_once get_stylesheet_directory() . '/admin-submissions.php';

add_action('admin_menu', function() {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_submissions';
    $unread = 0;
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") === $table) {
        $unread = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE read_flag = 0");
    }
    $badge = $unread > 0 ? ' <span class="awaiting-mod">' . $unread . '</span>' : '';

    add_menu_page(
        'KPMS Submissions',
        'KPMS Submissions' . $badge,
        'manage_options',
        'kpms-submissions',
        'kpms_submissions_page',
        'dashicons-email-alt',
        30
    );
});

// Enqueue nonce for front-end forms
add_action('wp_footer', function() {
    if (!is_page()) return;
    $template = get_page_template_slug();
    $form_pages = ['page-contact.php', 'page-apply-online.php', 'page-schedule-tour.php', 'page-careers.php'];
    if (in_array($template, $form_pages, true)) {
        $nonce = wp_create_nonce('kpms_form_nonce');
        $ajax_url = admin_url('admin-ajax.php');
        echo '<script>window.kpmsAjax={url:"' . esc_url($ajax_url) . '",nonce:"' . esc_attr($nonce) . '"};</script>';
    }
});

// ============================================================
// TEACHER DASHBOARD SYSTEM
// ============================================================

require_once get_stylesheet_directory() . '/teacher-dashboard.php';
require_once get_stylesheet_directory() . '/teacher-ajax-handler.php';

// Register Teacher Dashboard menu page
add_action('admin_menu', function() {
    add_menu_page(
        'Teacher Dashboard',
        'Teacher Dashboard',
        'edit_pages',
        'kpms-teacher-dashboard',
        'kpms_teacher_dashboard_page',
        'dashicons-welcome-learn-more',
        2
    );
});

// Register AJAX hooks for teacher dashboard
add_action('wp_ajax_kpms_save_announcement', 'kpms_save_announcement');
add_action('wp_ajax_kpms_delete_announcement', 'kpms_delete_announcement');
add_action('wp_ajax_kpms_get_announcement', 'kpms_get_announcement');
add_action('wp_ajax_kpms_save_event', 'kpms_save_event');
add_action('wp_ajax_kpms_delete_event', 'kpms_delete_event');
add_action('wp_ajax_kpms_get_event', 'kpms_get_event');
add_action('wp_ajax_kpms_save_staff_profile', 'kpms_save_staff_profile');
add_action('wp_ajax_kpms_get_recent_uploads', 'kpms_get_recent_uploads');
add_action('wp_ajax_kpms_delete_upload', 'kpms_delete_upload');
add_action('wp_ajax_kpms_update_section_image', 'kpms_update_section_image');
add_action('wp_ajax_kpms_save_staff', 'kpms_save_staff');
add_action('wp_ajax_kpms_delete_staff', 'kpms_delete_staff');
add_action('wp_ajax_kpms_get_staff', 'kpms_get_staff');

/**
 * Helper: get a section image URL, with fallback to default.
 */
function kpms_get_section_image($section, $default = '') {
    $url = get_option('kpms_section_image_' . $section, '');
    return !empty($url) ? $url : $default;
}

// Enqueue media uploader + localize JS on dashboard page
add_action('admin_enqueue_scripts', function($hook) {
    if ($hook !== 'toplevel_page_kpms-teacher-dashboard') return;
    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_localize_script('jquery', 'kpmsTeacher', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('kpms_teacher_nonce'),
        'user_id'  => get_current_user_id(),
    ]);
});

// ============================================================
// TEACHER ADMIN CLEANUP + REDIRECTS
// ============================================================

// Helper: check if current user is a teacher (not admin)
function kpms_is_teacher_user($user = null) {
    if (!$user) {
        $user = wp_get_current_user();
    }
    return in_array('kpms_teacher', (array) $user->roles, true);
}

// Redirect teachers to dashboard after login
add_filter('login_redirect', function($redirect_to, $requested, $user) {
    if (is_a($user, 'WP_User') && kpms_is_teacher_user($user)) {
        return admin_url('admin.php?page=kpms-teacher-dashboard');
    }
    return $redirect_to;
}, 10, 3);

// Redirect teachers away from default dashboard
add_action('admin_init', function() {
    if (!kpms_is_teacher_user()) return;
    global $pagenow;
    if ($pagenow === 'index.php' && !isset($_GET['page'])) {
        wp_redirect(admin_url('admin.php?page=kpms-teacher-dashboard'));
        exit;
    }
});

// Hide admin bar on frontend for teachers
add_filter('show_admin_bar', function($show) {
    if (kpms_is_teacher_user()) return false;
    return $show;
});

// Remove default dashboard widgets for non-admins
add_action('wp_dashboard_setup', function() {
    if (current_user_can('manage_options')) return;
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
});

// Remove unnecessary admin menus for teachers
add_action('admin_menu', function() {
    if (!kpms_is_teacher_user()) return;
    remove_menu_page('edit-comments.php');
    remove_menu_page('tools.php');
    remove_menu_page('themes.php');
    remove_menu_page('plugins.php');
    remove_menu_page('options-general.php');
    remove_menu_page('edit.php');
    remove_menu_page('users.php');
}, 999);

// Force classic editor for teachers
add_filter('use_block_editor_for_post', function($use) {
    if (kpms_is_teacher_user()) return false;
    return $use;
});

// ============================================================
// LOGIN PAGE BRANDING
// ============================================================

add_action('login_enqueue_scripts', function() {
    $logo_url = home_url('/wp-content/uploads/2026/02/Kamal-Public-School-2.png');
    ?>
    <style>
        body.login {
            background: linear-gradient(135deg, #003087 0%, #004ecb 60%, #002060 100%) !important;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }
        #login h1 a {
            background-image: url('<?php echo esc_url($logo_url); ?>') !important;
            background-size: 120px 120px !important;
            width: 120px !important;
            height: 120px !important;
            border-radius: 50% !important;
            border: 3px solid rgba(255, 209, 0, 0.6) !important;
            margin-bottom: 16px !important;
        }
        .login form {
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.2) !important;
            border: none !important;
        }
        .login form .input:focus {
            border-color: #FFD100 !important;
            box-shadow: 0 0 0 2px rgba(255, 209, 0, 0.3) !important;
        }
        .wp-core-ui .button-primary {
            background: #003087 !important;
            border-color: #003087 !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            text-shadow: none !important;
            box-shadow: none !important;
            padding: 6px 24px !important;
        }
        .wp-core-ui .button-primary:hover {
            background: #004ecb !important;
            border-color: #004ecb !important;
        }
        .login #nav a, .login #backtoblog a {
            color: rgba(255, 255, 255, 0.75) !important;
        }
        .login #nav a:hover, .login #backtoblog a:hover {
            color: #FFD100 !important;
        }
        .login .message, .login .success {
            border-left-color: #FFD100 !important;
        }
    </style>
    <?php
});

add_filter('login_headerurl', function() {
    return home_url('/');
});

add_filter('login_headertext', function() {
    return 'KPMS Staff Portal';
});

add_action('login_footer', function() {
    ?>
    <script>
    (function() {
        var back = document.getElementById('backtoblog');
        if (back) {
            var link = back.querySelector('a');
            if (link) link.textContent = '\u2190 Back to KPMS Website';
        }
    })();
    </script>
    <?php
});
