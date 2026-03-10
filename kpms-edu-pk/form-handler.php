<?php
/**
 * KPMS Form Handler
 * Processes AJAX form submissions, validates input, saves to DB, sends email.
 * Called via WordPress admin-ajax.php hooks.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main form submission handler
 */
function kpms_handle_form_submit() {
    // Verify nonce
    if (!isset($_POST['_kpms_nonce']) || !wp_verify_nonce($_POST['_kpms_nonce'], 'kpms_form_nonce')) {
        wp_send_json_error(['message' => 'Security check failed. Please refresh the page and try again.'], 403);
    }

    // Rate limiting: max 5 submissions per IP per hour
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
    if (kpms_is_rate_limited($ip)) {
        wp_send_json_error(['message' => 'Too many submissions. Please wait a while before trying again.'], 429);
    }

    // Get form type
    $form_type = sanitize_text_field($_POST['form_type'] ?? '');
    $valid_types = ['contact', 'application', 'tour', 'career'];
    if (!in_array($form_type, $valid_types, true)) {
        wp_send_json_error(['message' => 'Invalid form type.'], 400);
    }

    // Process based on form type
    switch ($form_type) {
        case 'contact':
            $result = kpms_process_contact($_POST);
            break;
        case 'application':
            $result = kpms_process_application($_POST);
            break;
        case 'tour':
            $result = kpms_process_tour($_POST);
            break;
        case 'career':
            $result = kpms_process_career($_POST);
            break;
    }

    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()], 400);
    }

    wp_send_json_success(['message' => "Thank you! We've received your submission and will get back to you within 2 business days."]);
}

/**
 * Rate limiting check
 */
function kpms_is_rate_limited($ip) {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_submissions';

    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table'") !== $table) {
        return false;
    }

    $one_hour_ago = gmdate('Y-m-d H:i:s', time() - 3600);
    $count = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table WHERE ip_address = %s AND submitted_at > %s",
        $ip, $one_hour_ago
    ));

    return $count >= 5;
}

/**
 * Save submission to database
 */
function kpms_save_submission($form_type, $name, $email, $phone, $message, $data_json) {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_submissions';
    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');

    $inserted = $wpdb->insert($table, [
        'form_type'    => $form_type,
        'name'         => $name,
        'email'        => $email,
        'phone'        => $phone,
        'message'      => $message,
        'data_json'    => $data_json,
        'ip_address'   => $ip,
        'submitted_at' => current_time('mysql', true),
        'status'       => 'new',
        'read_flag'    => 0,
    ], ['%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d']);

    if ($inserted === false) {
        return new WP_Error('db_error', 'Could not save submission. Please try again.');
    }

    return $wpdb->insert_id;
}

/**
 * Send email notification
 */
function kpms_send_notification($to, $subject, $form_type, $data) {
    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: KPMS Website <noreply@kpms.edu.pk>',
    ];

    // Add reply-to if email is available
    if (!empty($data['email'])) {
        $headers[] = 'Reply-To: ' . $data['email'];
    }

    $body = '<div style="font-family:Arial,sans-serif;max-width:600px;margin:0 auto;padding:20px;">';
    $body .= '<div style="background:#003087;color:#fff;padding:20px;border-radius:8px 8px 0 0;text-align:center;">';
    $body .= '<h2 style="margin:0;font-size:20px;">KPMS ' . ucfirst($form_type) . ' Submission</h2>';
    $body .= '</div>';
    $body .= '<div style="background:#f8f9fa;padding:20px;border:1px solid #e0e0e0;border-radius:0 0 8px 8px;">';

    foreach ($data as $key => $value) {
        if ($key === '_kpms_nonce' || $key === 'form_type' || $key === 'action' || empty($value)) continue;
        $label = ucwords(str_replace('_', ' ', $key));
        $body .= '<p style="margin:8px 0;"><strong style="color:#003087;">' . esc_html($label) . ':</strong><br>' . nl2br(esc_html($value)) . '</p>';
    }

    $body .= '<hr style="border:none;border-top:1px solid #ddd;margin:16px 0;">';
    $body .= '<p style="font-size:12px;color:#999;">Submitted on ' . current_time('F j, Y \a\t g:i A') . ' from IP ' . esc_html($_SERVER['REMOTE_ADDR'] ?? 'unknown') . '</p>';
    $body .= '</div></div>';

    wp_mail($to, $subject, $body, $headers);
}

// ============================================================
// FORM PROCESSORS
// ============================================================

function kpms_process_contact($data) {
    $name    = sanitize_text_field($data['name'] ?? '');
    $email   = sanitize_email($data['email'] ?? '');
    $phone   = sanitize_text_field($data['phone'] ?? '');
    $subject = sanitize_text_field($data['subject'] ?? 'General Inquiry');
    $message = sanitize_textarea_field($data['message'] ?? '');

    // Validate required fields
    if (empty($name))    return new WP_Error('missing', 'Name is required.');
    if (empty($email) || !is_email($email)) return new WP_Error('missing', 'A valid email address is required.');
    if (empty($message)) return new WP_Error('missing', 'Message is required.');

    $all_data = compact('name', 'email', 'phone', 'subject', 'message');
    $json = wp_json_encode($all_data);

    $saved = kpms_save_submission('contact', $name, $email, $phone, $message, $json);
    if (is_wp_error($saved)) return $saved;

    kpms_send_notification(
        'info@kpms.edu.pk',
        'New Contact Inquiry from ' . $name,
        'Contact',
        $all_data
    );

    return true;
}

function kpms_process_application($data) {
    $student_name    = sanitize_text_field($data['student_name'] ?? '');
    $date_of_birth   = sanitize_text_field($data['date_of_birth'] ?? '');
    $gender          = sanitize_text_field($data['gender'] ?? '');
    $grade           = sanitize_text_field($data['grade_applying_for'] ?? '');
    $previous_school = sanitize_text_field($data['previous_school'] ?? '');
    $parent_name     = sanitize_text_field($data['parent_name'] ?? '');
    $relationship    = sanitize_text_field($data['relationship'] ?? '');
    $parent_email    = sanitize_email($data['parent_email'] ?? '');
    $parent_phone    = sanitize_text_field($data['parent_phone'] ?? '');
    $address         = sanitize_textarea_field($data['address'] ?? '');
    $how_heard       = sanitize_text_field($data['how_heard'] ?? '');
    $notes           = sanitize_textarea_field($data['additional_notes'] ?? '');

    // Validate
    if (empty($student_name)) return new WP_Error('missing', 'Student name is required.');
    if (empty($date_of_birth)) return new WP_Error('missing', 'Date of birth is required.');
    if (empty($gender))        return new WP_Error('missing', 'Gender is required.');
    if (empty($grade))         return new WP_Error('missing', 'Grade level is required.');
    if (empty($parent_name))   return new WP_Error('missing', 'Parent/guardian name is required.');
    if (empty($parent_email) || !is_email($parent_email)) return new WP_Error('missing', 'A valid email address is required.');
    if (empty($parent_phone))  return new WP_Error('missing', 'Phone number is required.');
    if (empty($address))       return new WP_Error('missing', 'Home address is required.');

    $all_data = compact('student_name', 'date_of_birth', 'gender', 'grade', 'previous_school',
        'parent_name', 'relationship', 'parent_email', 'parent_phone', 'address', 'how_heard', 'notes');
    $json = wp_json_encode($all_data);

    $display_name = $parent_name . ' (Student: ' . $student_name . ')';
    $saved = kpms_save_submission('application', $display_name, $parent_email, $parent_phone, $notes, $json);
    if (is_wp_error($saved)) return $saved;

    kpms_send_notification(
        'admissions@kpms.edu.pk',
        'New Application: ' . $student_name . ' for Grade ' . $grade,
        'Application',
        $all_data
    );

    return true;
}

function kpms_process_tour($data) {
    $parent_name    = sanitize_text_field($data['parent_name'] ?? '');
    $email          = sanitize_email($data['email'] ?? '');
    $phone          = sanitize_text_field($data['phone'] ?? '');
    $preferred_date = sanitize_text_field($data['preferred_date'] ?? '');
    $preferred_time = sanitize_text_field($data['preferred_time'] ?? '');
    $grade_interest = sanitize_text_field($data['grade_interest'] ?? '');
    $tour_type      = sanitize_text_field($data['tour_type'] ?? '');
    $attendees      = sanitize_text_field($data['attendees'] ?? '1');
    $questions      = sanitize_textarea_field($data['questions'] ?? '');

    // Validate
    if (empty($parent_name))    return new WP_Error('missing', 'Name is required.');
    if (empty($email) || !is_email($email)) return new WP_Error('missing', 'A valid email address is required.');
    if (empty($phone))          return new WP_Error('missing', 'Phone number is required.');
    if (empty($preferred_date)) return new WP_Error('missing', 'Preferred date is required.');
    if (empty($preferred_time)) return new WP_Error('missing', 'Preferred time is required.');
    if (empty($tour_type))      return new WP_Error('missing', 'Tour type is required.');

    $all_data = compact('parent_name', 'email', 'phone', 'preferred_date', 'preferred_time',
        'grade_interest', 'tour_type', 'attendees', 'questions');
    $json = wp_json_encode($all_data);

    $saved = kpms_save_submission('tour', $parent_name, $email, $phone, $questions, $json);
    if (is_wp_error($saved)) return $saved;

    $tour_label = ucfirst(str_replace('-', ' ', $tour_type));
    kpms_send_notification(
        'admissions@kpms.edu.pk',
        'Tour Request: ' . $tour_label . ' on ' . $preferred_date,
        'Tour Request',
        $all_data
    );

    return true;
}

function kpms_process_career($data) {
    $name           = sanitize_text_field($data['full_name'] ?? '');
    $email          = sanitize_email($data['email'] ?? '');
    $phone          = sanitize_text_field($data['phone'] ?? '');
    $position       = sanitize_text_field($data['position'] ?? '');
    $cover_letter   = sanitize_textarea_field($data['cover_letter'] ?? '');

    // Validate
    if (empty($name))  return new WP_Error('missing', 'Full name is required.');
    if (empty($email) || !is_email($email)) return new WP_Error('missing', 'A valid email address is required.');
    if (empty($phone)) return new WP_Error('missing', 'Phone number is required.');
    if (empty($position)) return new WP_Error('missing', 'Please select a position.');

    $all_data = compact('name', 'email', 'phone', 'position', 'cover_letter');
    $json = wp_json_encode($all_data);

    $position_label = ucwords(str_replace('-', ' ', $position));
    $saved = kpms_save_submission('career', $name, $email, $phone, $cover_letter, $json);
    if (is_wp_error($saved)) return $saved;

    kpms_send_notification(
        'careers@kpms.edu.pk',
        'Job Application: ' . $name . ' for ' . $position_label,
        'Career Application',
        $all_data
    );

    return true;
}
