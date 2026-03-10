<?php
/**
 * KPMS Submissions Admin Viewer
 * Displays form submissions in wp-admin with tabs, detail view, status updates, CSV export.
 */

if (!defined('ABSPATH')) {
    exit;
}

function kpms_submissions_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'kpms_submissions';

    // Handle actions
    if (isset($_GET['action']) && isset($_GET['id']) && wp_verify_nonce($_GET['_wpnonce'] ?? '', 'kpms_sub_action')) {
        $id = intval($_GET['id']);
        $action = sanitize_text_field($_GET['action']);
        if ($action === 'mark_read') {
            $wpdb->update($table, ['read_flag' => 1, 'status' => 'read'], ['id' => $id]);
        } elseif ($action === 'mark_replied') {
            $wpdb->update($table, ['status' => 'replied'], ['id' => $id]);
        } elseif ($action === 'delete_sub') {
            $wpdb->delete($table, ['id' => $id]);
        }
        $redirect = remove_query_arg(['action', 'id', '_wpnonce']);
        echo '<script>window.location.href="' . esc_url($redirect) . '";</script>';
        return;
    }

    // Current tab
    $tabs = [
        'all'         => 'All',
        'contact'     => 'Contact',
        'application' => 'Applications',
        'tour'        => 'Tour Requests',
        'career'      => 'Career Applications',
    ];
    $current_tab = sanitize_text_field($_GET['tab'] ?? 'all');
    if (!isset($tabs[$current_tab])) $current_tab = 'all';

    // Detail view
    $detail = null;
    if (isset($_GET['view'])) {
        $detail = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", intval($_GET['view'])));
        if ($detail && !$detail->read_flag) {
            $wpdb->update($table, ['read_flag' => 1, 'status' => 'read'], ['id' => $detail->id]);
            $detail->status = 'read';
            $detail->read_flag = 1;
        }
    }

    // Fetch submissions
    $where = ($current_tab !== 'all') ? $wpdb->prepare("WHERE form_type = %s", $current_tab) : '';
    $submissions = $wpdb->get_results("SELECT * FROM $table $where ORDER BY submitted_at DESC LIMIT 200");

    // Count unread per type
    $counts = $wpdb->get_results("SELECT form_type, COUNT(*) as total, SUM(CASE WHEN read_flag = 0 THEN 1 ELSE 0 END) as unread FROM $table GROUP BY form_type", OBJECT_K);
    $total_unread = 0;
    foreach ($counts as $c) $total_unread += $c->unread;

    ?>
    <style>
        .kpms-admin-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .kpms-tabs { display: flex; gap: 0; border-bottom: 2px solid #e0e0e0; margin-bottom: 20px; }
        .kpms-tab { padding: 10px 20px; text-decoration: none; color: #555; font-weight: 500; border-bottom: 2px solid transparent; margin-bottom: -2px; }
        .kpms-tab:hover { color: #003087; }
        .kpms-tab.active { color: #003087; border-bottom-color: #003087; font-weight: 700; }
        .kpms-tab .badge { background: #e74c3c; color: #fff; font-size: 11px; padding: 1px 6px; border-radius: 10px; margin-left: 4px; }
        .kpms-table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 6px; overflow: hidden; }
        .kpms-table th { background: #f7f7f7; padding: 10px 14px; text-align: left; font-size: 12px; text-transform: uppercase; color: #666; font-weight: 600; }
        .kpms-table td { padding: 10px 14px; border-top: 1px solid #f0f0f0; font-size: 13px; }
        .kpms-table tr:hover td { background: #f8faff; }
        .kpms-table tr.unread td { font-weight: 600; background: #fffce6; }
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .status-new { background: #fff3cd; color: #856404; }
        .status-read { background: #d4edda; color: #155724; }
        .status-replied { background: #cce5ff; color: #004085; }
        .kpms-detail { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .kpms-detail h3 { margin: 0 0 16px; color: #003087; }
        .kpms-detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .kpms-detail-label { width: 180px; font-weight: 600; color: #555; flex-shrink: 0; }
        .kpms-detail-value { flex: 1; color: #333; }
        .kpms-actions { margin-top: 16px; display: flex; gap: 8px; }
        .kpms-actions a { display: inline-block; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 500; }
        .btn-read { background: #28a745; color: #fff; }
        .btn-replied { background: #007bff; color: #fff; }
        .btn-delete { background: #dc3545; color: #fff; }
        .kpms-empty { text-align: center; padding: 60px 20px; color: #999; }
        .export-group { display: flex; gap: 6px; align-items: center; }
        .export-group a { display: inline-block; padding: 6px 14px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; color: #fff; transition: opacity 0.2s; }
        .export-group a:hover { opacity: 0.85; color: #fff; }
        .btn-export-csv { background: #28a745; }
        .btn-export-excel { background: #007bff; }
        .btn-export-pdf { background: #dc3545; }
    </style>

    <div class="wrap kpms-admin-wrap">
        <h1>KPMS Submissions</h1>

        <?php if ($detail): ?>
            <p><a href="<?php echo esc_url(remove_query_arg('view')); ?>">&larr; Back to list</a></p>
            <div class="kpms-detail">
                <h3><?php echo esc_html(ucfirst($detail->form_type)); ?> Submission #<?php echo $detail->id; ?>
                    <span class="status-badge status-<?php echo esc_attr($detail->status); ?>"><?php echo esc_html($detail->status); ?></span>
                </h3>
                <div class="kpms-detail-row"><div class="kpms-detail-label">Date</div><div class="kpms-detail-value"><?php echo esc_html(date('F j, Y \a\t g:i A', strtotime($detail->submitted_at))); ?></div></div>
                <div class="kpms-detail-row"><div class="kpms-detail-label">Name</div><div class="kpms-detail-value"><?php echo esc_html($detail->name); ?></div></div>
                <div class="kpms-detail-row"><div class="kpms-detail-label">Email</div><div class="kpms-detail-value"><a href="mailto:<?php echo esc_attr($detail->email); ?>"><?php echo esc_html($detail->email); ?></a></div></div>
                <div class="kpms-detail-row"><div class="kpms-detail-label">Phone</div><div class="kpms-detail-value"><?php echo esc_html($detail->phone); ?></div></div>
                <?php if (!empty($detail->message)): ?>
                <div class="kpms-detail-row"><div class="kpms-detail-label">Message</div><div class="kpms-detail-value"><?php echo nl2br(esc_html($detail->message)); ?></div></div>
                <?php endif; ?>

                <?php
                $json_data = json_decode($detail->data_json, true);
                if (is_array($json_data)):
                    foreach ($json_data as $key => $val):
                        if (in_array($key, ['name', 'email', 'phone', 'message', 'full_name', 'parent_email', 'parent_phone']) || empty($val)) continue;
                ?>
                <div class="kpms-detail-row">
                    <div class="kpms-detail-label"><?php echo esc_html(ucwords(str_replace('_', ' ', $key))); ?></div>
                    <div class="kpms-detail-value"><?php echo nl2br(esc_html($val)); ?></div>
                </div>
                <?php endforeach; endif; ?>

                <div class="kpms-actions">
                    <?php if ($detail->status !== 'replied'): ?>
                    <a href="<?php echo wp_nonce_url(add_query_arg(['action' => 'mark_replied', 'id' => $detail->id]), 'kpms_sub_action'); ?>" class="btn-replied">Mark as Replied</a>
                    <?php endif; ?>
                    <a href="mailto:<?php echo esc_attr($detail->email); ?>" class="btn-read">Reply via Email</a>
                    <a href="<?php echo wp_nonce_url(add_query_arg(['action' => 'delete_sub', 'id' => $detail->id]), 'kpms_sub_action'); ?>" class="btn-delete" onclick="return confirm('Delete this submission?');">Delete</a>
                </div>
            </div>
        <?php else: ?>

        <!-- Tabs -->
        <div class="kpms-tabs">
            <?php foreach ($tabs as $slug => $label):
                $unread = ($slug === 'all') ? $total_unread : ($counts[$slug]->unread ?? 0);
                $active = ($current_tab === $slug) ? ' active' : '';
            ?>
            <a href="<?php echo esc_url(add_query_arg('tab', $slug)); ?>" class="kpms-tab<?php echo $active; ?>">
                <?php echo esc_html($label); ?>
                <?php if ($unread > 0): ?><span class="badge"><?php echo $unread; ?></span><?php endif; ?>
            </a>
            <?php endforeach; ?>

            <div class="export-group" style="margin-left:auto;">
                <a href="<?php echo wp_nonce_url(add_query_arg(['export_kpms' => 'csv', 'tab' => $current_tab], admin_url('admin.php?page=kpms-submissions')), 'kpms_export'); ?>" class="btn-export-csv">Export CSV</a>
                <a href="<?php echo wp_nonce_url(add_query_arg(['export_kpms' => 'excel', 'tab' => $current_tab], admin_url('admin.php?page=kpms-submissions')), 'kpms_export'); ?>" class="btn-export-excel">Export Excel</a>
                <a href="<?php echo wp_nonce_url(add_query_arg(['export_kpms' => 'pdf', 'tab' => $current_tab], admin_url('admin.php?page=kpms-submissions')), 'kpms_export'); ?>" class="btn-export-pdf" target="_blank">Export PDF</a>
            </div>
        </div>

        <?php if (empty($submissions)): ?>
            <div class="kpms-empty">
                <p style="font-size:48px; margin:0;">📭</p>
                <p>No submissions yet.</p>
            </div>
        <?php else: ?>
        <table class="kpms-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $sub): ?>
                <tr class="<?php echo !$sub->read_flag ? 'unread' : ''; ?>">
                    <td><?php echo esc_html(date('M j, Y g:i A', strtotime($sub->submitted_at))); ?></td>
                    <td><?php echo esc_html(ucfirst($sub->form_type)); ?></td>
                    <td><?php echo esc_html($sub->name); ?></td>
                    <td><a href="mailto:<?php echo esc_attr($sub->email); ?>"><?php echo esc_html($sub->email); ?></a></td>
                    <td><span class="status-badge status-<?php echo esc_attr($sub->status); ?>"><?php echo esc_html($sub->status); ?></span></td>
                    <td><a href="<?php echo esc_url(add_query_arg('view', $sub->id)); ?>">View</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <?php endif; ?>
    </div>
    <?php
}
