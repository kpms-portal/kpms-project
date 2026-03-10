<?php
/**
 * KPMS Teacher Dashboard — AJAX Handlers
 * Handles CRUD for announcements, events, staff profiles, and photo management.
 */

if (!defined('ABSPATH')) exit;

// ============================================================
// ANNOUNCEMENTS
// ============================================================

function kpms_save_announcement() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_announcements';

    $id         = intval($_POST['id'] ?? 0);
    $title      = sanitize_text_field($_POST['title'] ?? '');
    $message    = sanitize_textarea_field($_POST['message'] ?? '');
    $priority   = sanitize_text_field($_POST['priority'] ?? 'normal');
    $expires_at = sanitize_text_field($_POST['expires_at'] ?? '');

    if (empty($title) || empty($message)) {
        wp_send_json_error('Title and message are required.');
    }
    if (!in_array($priority, ['normal', 'important', 'urgent'], true)) {
        $priority = 'normal';
    }

    // Validate expires_at if provided
    if (!empty($expires_at)) {
        $d = DateTime::createFromFormat('Y-m-d', $expires_at);
        if (!$d || $d->format('Y-m-d') !== $expires_at) {
            $expires_at = null;
        }
    } else {
        $expires_at = null;
    }

    $now = current_time('mysql');

    if ($id > 0) {
        // Update — ownership check
        $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
        if (!$existing) {
            wp_send_json_error('Announcement not found.');
        }
        if ((int) $existing->author_id !== get_current_user_id() && !current_user_can('manage_options')) {
            wp_send_json_error('You can only edit your own announcements.');
        }
        $wpdb->update($table, [
            'title'      => $title,
            'message'    => $message,
            'priority'   => $priority,
            'expires_at' => $expires_at,
            'updated_at' => $now,
        ], ['id' => $id], ['%s', '%s', '%s', '%s', '%s'], ['%d']);
        wp_send_json_success(['message' => 'Announcement updated.', 'id' => $id]);
    } else {
        // Insert
        $wpdb->insert($table, [
            'author_id'  => get_current_user_id(),
            'title'      => $title,
            'message'    => $message,
            'priority'   => $priority,
            'expires_at' => $expires_at,
            'created_at' => $now,
            'updated_at' => $now,
        ], ['%d', '%s', '%s', '%s', '%s', '%s', '%s']);
        wp_send_json_success(['message' => 'Announcement posted.', 'id' => $wpdb->insert_id]);
    }
}

function kpms_delete_announcement() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_announcements';
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        wp_send_json_error('Invalid ID.');
    }

    $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$existing) {
        wp_send_json_error('Announcement not found.');
    }
    if ((int) $existing->author_id !== get_current_user_id() && !current_user_can('manage_options')) {
        wp_send_json_error('You can only delete your own announcements.');
    }

    $wpdb->delete($table, ['id' => $id], ['%d']);
    wp_send_json_success(['message' => 'Announcement deleted.']);
}

function kpms_get_announcement() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_announcements';
    $id = intval($_POST['id'] ?? 0);

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$row) {
        wp_send_json_error('Announcement not found.');
    }

    wp_send_json_success($row);
}

// ============================================================
// EVENTS
// ============================================================

function kpms_save_event() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_events';

    $id          = intval($_POST['id'] ?? 0);
    $event_name  = sanitize_text_field($_POST['event_name'] ?? '');
    $event_date  = sanitize_text_field($_POST['event_date'] ?? '');
    $event_time  = sanitize_text_field($_POST['event_time'] ?? '');
    $location    = sanitize_text_field($_POST['location'] ?? '');
    $description = sanitize_textarea_field($_POST['description'] ?? '');

    if (empty($event_name) || empty($event_date)) {
        wp_send_json_error('Event name and date are required.');
    }

    // Validate date format Y-m-d
    $d = DateTime::createFromFormat('Y-m-d', $event_date);
    if (!$d || $d->format('Y-m-d') !== $event_date) {
        wp_send_json_error('Invalid date format. Use YYYY-MM-DD.');
    }

    $now = current_time('mysql');

    if ($id > 0) {
        $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
        if (!$existing) {
            wp_send_json_error('Event not found.');
        }
        if ((int) $existing->author_id !== get_current_user_id() && !current_user_can('manage_options')) {
            wp_send_json_error('You can only edit your own events.');
        }
        $wpdb->update($table, [
            'event_name'  => $event_name,
            'event_date'  => $event_date,
            'event_time'  => $event_time,
            'location'    => $location,
            'description' => $description,
            'updated_at'  => $now,
        ], ['id' => $id], ['%s', '%s', '%s', '%s', '%s', '%s'], ['%d']);
        wp_send_json_success(['message' => 'Event updated.', 'id' => $id]);
    } else {
        $wpdb->insert($table, [
            'author_id'   => get_current_user_id(),
            'event_name'  => $event_name,
            'event_date'  => $event_date,
            'event_time'  => $event_time,
            'location'    => $location,
            'description' => $description,
            'created_at'  => $now,
            'updated_at'  => $now,
        ], ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s']);
        wp_send_json_success(['message' => 'Event created.', 'id' => $wpdb->insert_id]);
    }
}

function kpms_delete_event() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_events';
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        wp_send_json_error('Invalid ID.');
    }

    $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$existing) {
        wp_send_json_error('Event not found.');
    }
    if ((int) $existing->author_id !== get_current_user_id() && !current_user_can('manage_options')) {
        wp_send_json_error('You can only delete your own events.');
    }

    $wpdb->delete($table, ['id' => $id], ['%d']);
    wp_send_json_success(['message' => 'Event deleted.']);
}

function kpms_get_event() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_events';
    $id = intval($_POST['id'] ?? 0);

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$row) {
        wp_send_json_error('Event not found.');
    }

    wp_send_json_success($row);
}

// ============================================================
// STAFF PROFILES
// ============================================================

function kpms_save_staff_profile() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_staff';

    // user_id always from session, never from POST
    $user_id        = get_current_user_id();
    $photo_url      = esc_url_raw($_POST['photo_url'] ?? '');
    $bio            = sanitize_textarea_field($_POST['bio'] ?? '');
    $quote          = sanitize_text_field($_POST['quote'] ?? '');
    $department     = sanitize_text_field($_POST['department'] ?? '');
    $qualifications = sanitize_textarea_field($_POST['qualifications'] ?? '');

    $now = current_time('mysql');

    // Upsert by user_id
    $existing = $wpdb->get_row($wpdb->prepare("SELECT id FROM $table WHERE user_id = %d", $user_id));

    if ($existing) {
        $wpdb->update($table, [
            'photo_url'      => $photo_url,
            'bio'            => $bio,
            'quote'          => $quote,
            'department'     => $department,
            'qualifications' => $qualifications,
            'updated_at'     => $now,
        ], ['user_id' => $user_id], ['%s', '%s', '%s', '%s', '%s', '%s'], ['%d']);
    } else {
        $wpdb->insert($table, [
            'user_id'        => $user_id,
            'photo_url'      => $photo_url,
            'bio'            => $bio,
            'quote'          => $quote,
            'department'     => $department,
            'qualifications' => $qualifications,
            'updated_at'     => $now,
        ], ['%d', '%s', '%s', '%s', '%s', '%s', '%s']);
    }

    wp_send_json_success(['message' => 'Staff profile saved.']);
}

// ============================================================
// PHOTO / UPLOAD MANAGEMENT
// ============================================================

function kpms_get_recent_uploads() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    $args = [
        'post_type'      => 'attachment',
        'post_status'    => 'inherit',
        'author'         => get_current_user_id(),
        'posts_per_page' => 20,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'post_mime_type' => 'image',
    ];

    $attachments = get_posts($args);
    $uploads = [];

    foreach ($attachments as $att) {
        $thumb = wp_get_attachment_image_src($att->ID, 'thumbnail');
        $full  = wp_get_attachment_image_src($att->ID, 'full');
        $uploads[] = [
            'id'        => $att->ID,
            'title'     => $att->post_title,
            'thumbnail' => $thumb ? $thumb[0] : '',
            'full'      => $full ? $full[0] : '',
            'date'      => $att->post_date,
        ];
    }

    wp_send_json_success($uploads);
}

// ============================================================
// SECTION IMAGE MANAGEMENT
// ============================================================

function kpms_update_section_image() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    $section = sanitize_text_field($_POST['section'] ?? '');
    $image_url = esc_url_raw($_POST['image_url'] ?? '');

    if (empty($section)) {
        wp_send_json_error('Section slug is required.');
    }

    // Whitelist of allowed section slugs
    $allowed = [
        'hero_bg',
        'feature_philosophy', 'feature_faculty', 'feature_community',
        'video_tour', 'video_tour_url',
        'gallery_morning_assembly', 'gallery_library', 'gallery_classrooms',
        'gallery_art_studio', 'gallery_outdoor_learning', 'gallery_play_area',
        'news_card_1', 'news_card_2', 'news_card_3',
        'faculty_photo_1', 'faculty_photo_2', 'faculty_photo_3',
        'faculty_photo_4', 'faculty_photo_5', 'faculty_photo_6',
        'campus_main',
    ];

    if (!in_array($section, $allowed, true)) {
        wp_send_json_error('Invalid section slug.');
    }

    $option_key = 'kpms_section_image_' . $section;

    if (empty($image_url)) {
        delete_option($option_key);
    } else {
        update_option($option_key, $image_url);
    }

    wp_send_json_success(['message' => 'Image updated.', 'section' => $section]);
}

function kpms_delete_upload() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        wp_send_json_error('Invalid attachment ID.');
    }

    $attachment = get_post($id);
    if (!$attachment || $attachment->post_type !== 'attachment') {
        wp_send_json_error('Attachment not found.');
    }

    // Ownership check
    if ((int) $attachment->post_author !== get_current_user_id() && !current_user_can('manage_options')) {
        wp_send_json_error('You can only delete your own uploads.');
    }

    wp_delete_attachment($id, true);
    wp_send_json_success(['message' => 'Upload deleted.']);
}

// ============================================================
// STAFF DIRECTORY CRUD
// ============================================================

function kpms_save_staff() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_staff';

    $id            = intval($_POST['staff_id'] ?? 0);
    $name          = sanitize_text_field($_POST['name'] ?? '');
    $title         = sanitize_text_field($_POST['title'] ?? '');
    $category      = sanitize_text_field($_POST['category'] ?? 'teaching');
    $department    = sanitize_text_field($_POST['department'] ?? '');
    $bio           = sanitize_textarea_field($_POST['bio'] ?? '');
    $qualifications = sanitize_textarea_field($_POST['qualifications'] ?? '');
    $quote         = sanitize_text_field($_POST['quote'] ?? '');
    $circle_color  = sanitize_text_field($_POST['circle_color'] ?? '#003087');
    $display_order = intval($_POST['display_order'] ?? 0);
    $photo_url     = esc_url_raw($_POST['photo_url'] ?? '');
    $featured_on_homepage = min(1, max(0, intval($_POST['featured_on_homepage'] ?? 0)));
    $email         = sanitize_email($_POST['email'] ?? '');
    $phone         = sanitize_text_field($_POST['phone'] ?? '');

    if (empty($name)) {
        wp_send_json_error('Name is required.');
    }
    if (!in_array($category, ['leadership', 'teaching', 'support'], true)) {
        $category = 'teaching';
    }
    // Validate circle_color is a hex color
    if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $circle_color)) {
        $circle_color = '#003087';
    }

    $now = current_time('mysql');
    $data = [
        'user_id'              => get_current_user_id(),
        'name'                 => $name,
        'title'                => $title,
        'category'             => $category,
        'department'           => $department,
        'bio'                  => $bio,
        'qualifications'       => $qualifications,
        'quote'                => $quote,
        'circle_color'         => $circle_color,
        'display_order'        => $display_order,
        'photo_url'            => $photo_url,
        'featured_on_homepage' => $featured_on_homepage,
        'email'                => $email,
        'phone'                => $phone,
        'is_active'            => 1,
        'updated_at'           => $now,
    ];
    $formats = ['%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s','%d','%s','%s','%d','%s'];

    if ($id > 0) {
        $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
        if (!$existing) {
            wp_send_json_error('Staff member not found.');
        }
        $result = $wpdb->update($table, $data, ['id' => $id], $formats, ['%d']);
        if ($result === false) {
            wp_send_json_error('Database error: ' . $wpdb->last_error);
        }
        wp_send_json_success(['message' => 'Staff member updated.', 'id' => $id]);
    } else {
        $result = $wpdb->insert($table, $data, $formats);
        if ($result === false) {
            wp_send_json_error('Database error: ' . $wpdb->last_error);
        }
        wp_send_json_success(['message' => 'Staff member added.', 'id' => $wpdb->insert_id]);
    }
}

function kpms_delete_staff() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_staff';
    $id = intval($_POST['staff_id'] ?? 0);

    if ($id <= 0) {
        wp_send_json_error('Invalid staff ID.');
    }

    $existing = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$existing) {
        wp_send_json_error('Staff member not found.');
    }

    $wpdb->delete($table, ['id' => $id], ['%d']);
    wp_send_json_success(['message' => 'Staff member removed.']);
}

function kpms_get_staff() {
    check_ajax_referer('kpms_teacher_nonce', 'nonce');
    if (!current_user_can('edit_pages')) {
        wp_send_json_error('Permission denied.');
    }

    global $wpdb;
    $table = $wpdb->prefix . 'kpms_staff';
    $id = intval($_POST['staff_id'] ?? 0);

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
    if (!$row) {
        wp_send_json_error('Staff member not found.');
    }

    wp_send_json_success($row);
}
