<?php
/**
 * KPMS Teacher Dashboard — Main UI
 * Renders welcome header, 5 quick-action cards, and activity feed.
 */

if (!defined('ABSPATH')) exit;

function kpms_teacher_dashboard_page() {
    global $wpdb;
    $current_user = wp_get_current_user();
    $is_admin = current_user_can('manage_options');
    $user_id = get_current_user_id();

    // Fetch data
    $announcements_table = $wpdb->prefix . 'kpms_announcements';
    $events_table = $wpdb->prefix . 'kpms_events';
    $staff_table = $wpdb->prefix . 'kpms_staff';
    $submissions_table = $wpdb->prefix . 'kpms_submissions';

    // Own announcements
    if ($is_admin) {
        $my_announcements = $wpdb->get_results("SELECT * FROM $announcements_table ORDER BY created_at DESC LIMIT 20");
    } else {
        $my_announcements = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $announcements_table WHERE author_id = %d ORDER BY created_at DESC LIMIT 20", $user_id
        ));
    }

    // Upcoming events
    $today = current_time('Y-m-d');
    $upcoming_events = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $events_table WHERE event_date >= %s ORDER BY event_date ASC, event_time ASC LIMIT 20", $today
    ));

    // Staff profile
    $staff_profile = $wpdb->get_row($wpdb->prepare("SELECT * FROM $staff_table WHERE user_id = %d", $user_id));

    // Activity feed data
    $recent_submissions = $wpdb->get_results("SELECT * FROM $submissions_table ORDER BY submitted_at DESC LIMIT 5");
    $recent_announcements = $wpdb->get_results("SELECT a.*, u.display_name FROM $announcements_table a LEFT JOIN {$wpdb->users} u ON a.author_id = u.ID ORDER BY a.created_at DESC LIMIT 5");
    $feed_events = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $events_table WHERE event_date >= %s ORDER BY event_date ASC LIMIT 5", $today
    ));
    ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

        .kpms-dashboard * { box-sizing: border-box; }
        .kpms-dashboard {
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            max-width: 1400px;
            margin: 0;
            padding: 20px;
            background: #f5f7fb;
            min-height: 100vh;
        }

        /* Welcome Header */
        .kpms-welcome {
            background: linear-gradient(135deg, #003087 0%, #004ecb 100%);
            border-radius: 16px;
            padding: 32px 40px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }
        .kpms-welcome::after {
            content: '';
            position: absolute;
            right: -40px;
            top: -40px;
            width: 200px;
            height: 200px;
            background: rgba(255, 209, 0, 0.1);
            border-radius: 50%;
        }
        .kpms-welcome-logo {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 209, 0, 0.6);
            flex-shrink: 0;
        }
        .kpms-welcome-text h1 {
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 4px;
        }
        .kpms-welcome-text p {
            margin: 0;
            opacity: 0.85;
            font-size: 14px;
        }
        .kpms-welcome-badge {
            margin-left: auto;
            background: rgba(255, 209, 0, 0.2);
            color: #FFD100;
            padding: 8px 18px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid rgba(255, 209, 0, 0.3);
            white-space: nowrap;
        }

        /* Cards Grid */
        .kpms-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
            margin-bottom: 28px;
        }
        .kpms-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-left: 4px solid #FFD100;
            overflow: hidden;
        }
        .kpms-card-header {
            padding: 18px 24px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }
        .kpms-card-header h2 {
            font-size: 17px;
            font-weight: 700;
            color: #003087;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .kpms-card-header h2 .dashicons {
            font-size: 20px;
            width: 20px;
            height: 20px;
            color: #FFD100;
        }
        .kpms-card-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            font-size: 18px;
            transition: transform 0.2s;
            padding: 4px;
        }
        .kpms-card-toggle.collapsed { transform: rotate(-90deg); }
        .kpms-card-body {
            padding: 0 24px 24px;
        }
        .kpms-card-body.collapsed { display: none; }

        /* Forms */
        .kpms-form-group { margin-bottom: 14px; }
        .kpms-form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: #333;
            margin-bottom: 5px;
        }
        .kpms-form-group input[type="text"],
        .kpms-form-group input[type="date"],
        .kpms-form-group input[type="time"],
        .kpms-form-group textarea,
        .kpms-form-group select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #dde2ea;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s;
            background: #fafbfd;
        }
        .kpms-form-group input:focus,
        .kpms-form-group textarea:focus,
        .kpms-form-group select:focus {
            outline: none;
            border-color: #003087;
            box-shadow: 0 0 0 3px rgba(0, 48, 135, 0.1);
        }
        .kpms-form-group textarea { resize: vertical; min-height: 80px; }

        .kpms-radio-group {
            display: flex;
            gap: 16px;
            margin-top: 4px;
        }
        .kpms-radio-group label {
            font-weight: 500;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .kpms-btn {
            padding: 10px 22px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .kpms-btn-primary {
            background: #003087;
            color: #fff;
        }
        .kpms-btn-primary:hover { background: #004ecb; }
        .kpms-btn-gold {
            background: #FFD100;
            color: #003087;
        }
        .kpms-btn-gold:hover { background: #e6bc00; }
        .kpms-btn-danger {
            background: #dc3545;
            color: #fff;
            padding: 5px 12px;
            font-size: 12px;
        }
        .kpms-btn-danger:hover { background: #c82333; }
        .kpms-btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }
        .kpms-btn-edit {
            background: #e8edf5;
            color: #003087;
            padding: 5px 12px;
            font-size: 12px;
        }

        /* Lists */
        .kpms-item-list {
            margin-top: 16px;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }
        .kpms-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }
        .kpms-item:last-child { border-bottom: none; }
        .kpms-item-info h4 {
            margin: 0 0 3px;
            font-size: 14px;
            font-weight: 600;
            color: #222;
        }
        .kpms-item-info p {
            margin: 0;
            font-size: 12px;
            color: #777;
        }
        .kpms-item-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        /* Priority badges */
        .kpms-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .kpms-badge-normal { background: #d4edda; color: #155724; }
        .kpms-badge-important { background: #fff3cd; color: #856404; }
        .kpms-badge-urgent { background: #f8d7da; color: #721c24; }

        /* Upload grid */
        .kpms-upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 12px;
        }
        .kpms-upload-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 1;
            border: 2px solid #eee;
        }
        .kpms-upload-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .kpms-upload-item .kpms-upload-delete {
            position: absolute;
            top: 4px;
            right: 4px;
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .kpms-upload-item:hover .kpms-upload-delete { opacity: 1; }

        /* Staff photo preview */
        .kpms-staff-photo-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #FFD100;
            margin-bottom: 10px;
        }

        /* Activity Feed */
        .kpms-feed {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 24px;
        }
        .kpms-feed-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            padding: 20px 24px;
        }
        .kpms-feed-card h3 {
            font-size: 15px;
            font-weight: 700;
            color: #003087;
            margin: 0 0 14px;
            padding-bottom: 10px;
            border-bottom: 2px solid #FFD100;
        }
        .kpms-feed-item {
            padding: 8px 0;
            border-bottom: 1px solid #f5f5f5;
            font-size: 13px;
        }
        .kpms-feed-item:last-child { border-bottom: none; }
        .kpms-feed-item strong { color: #222; }
        .kpms-feed-item .kpms-feed-meta {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }

        /* Modal */
        .kpms-modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100000;
            align-items: center;
            justify-content: center;
        }
        .kpms-modal-overlay.active { display: flex; }
        .kpms-modal {
            background: #fff;
            border-radius: 14px;
            padding: 32px;
            width: 90%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        .kpms-modal h3 {
            margin: 0 0 20px;
            font-size: 20px;
            color: #003087;
        }
        .kpms-modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .kpms-btn-cancel {
            background: #eee;
            color: #333;
        }

        .kpms-msg {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
            display: none;
        }
        .kpms-msg-success { background: #d4edda; color: #155724; display: block; }
        .kpms-msg-error { background: #f8d7da; color: #721c24; display: block; }

        /* Image Manager */
        .kpms-img-group {
            border: 1px solid #e8ecf2;
            border-radius: 10px;
            margin-bottom: 12px;
            overflow: hidden;
        }
        .kpms-img-group-header {
            padding: 12px 16px;
            background: #f8f9fc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }
        .kpms-img-group-header strong {
            font-size: 14px;
            color: #003087;
        }
        .kpms-img-group-count {
            font-size: 11px;
            color: #999;
            background: #eee;
            padding: 2px 8px;
            border-radius: 10px;
        }
        .kpms-img-group.collapsed .kpms-img-group-body { display: none; }
        .kpms-img-group-body { padding: 12px 16px; }
        .kpms-img-slots {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
        }
        .kpms-img-slot {
            position: relative;
            text-align: center;
        }
        .kpms-img-preview {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            aspect-ratio: 16/10;
            cursor: pointer;
            border: 2px solid #e8ecf2;
            transition: border-color 0.2s;
        }
        .kpms-img-preview:hover { border-color: #FFD100; }
        .kpms-img-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .kpms-img-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 48, 135, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .kpms-img-preview:hover .kpms-img-overlay { opacity: 1; }
        .kpms-img-overlay .dashicons {
            color: #fff;
            font-size: 28px;
            width: 28px;
            height: 28px;
        }
        .kpms-img-label {
            font-size: 11px;
            color: #555;
            margin-top: 5px;
            font-weight: 500;
        }
        .kpms-img-reset {
            position: absolute;
            top: 2px;
            right: 2px;
            background: rgba(220, 53, 69, 0.9);
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            z-index: 2;
        }
        .kpms-video-slot {
            position: relative;
            text-align: center;
            background: #f0f4f8;
            border: 2px dashed #c8d1dc;
            border-radius: 8px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .kpms-video-info {
            display: flex;
            align-items: center;
            font-size: 12px;
            color: #333;
        }

        /* Staff CRUD */
        .kpms-staff-tabs {
            display: flex;
            gap: 4px;
        }
        .kpms-tab {
            padding: 6px 14px;
            border: 1.5px solid #dde2ea;
            border-radius: 8px;
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            color: #555;
            transition: all 0.2s;
        }
        .kpms-tab.active {
            background: #003087;
            color: #fff;
            border-color: #003087;
        }
        .kpms-tab-count {
            display: inline-block;
            background: rgba(0,0,0,0.08);
            padding: 0 6px;
            border-radius: 8px;
            font-size: 10px;
            margin-left: 2px;
        }
        .kpms-tab.active .kpms-tab-count {
            background: rgba(255,255,255,0.25);
        }
        .kpms-staff-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s;
        }
        .kpms-staff-row:hover { background: #f8f9fc; margin: 0 -24px; padding: 10px 24px; }
        .kpms-staff-row:last-child { border-bottom: none; }
        .kpms-staff-row-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .kpms-staff-row-circle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            font-family: 'DM Sans', sans-serif;
            flex-shrink: 0;
        }
        .kpms-staff-row-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .kpms-staff-row-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }
        .kpms-cat-badge {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 10px;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kpms-color-swatches {
            display: flex;
            gap: 6px;
            margin-top: 4px;
        }
        .kpms-swatch {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.15s;
        }
        .kpms-swatch:hover { transform: scale(1.1); }
        .kpms-swatch.active {
            border-color: #222;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #222;
        }

        @media (max-width: 768px) {
            .kpms-welcome { flex-direction: column; text-align: center; padding: 24px 20px; }
            .kpms-welcome-badge { margin-left: 0; margin-top: 10px; }
            .kpms-cards, .kpms-feed { grid-template-columns: 1fr; }
            .kpms-staff-tabs { flex-wrap: wrap; }
            .kpms-staff-row { flex-direction: column; align-items: flex-start; gap: 8px; }
            .kpms-staff-row-actions { width: 100%; justify-content: flex-end; }
        }
    </style>

    <div class="kpms-dashboard">
        <!-- Welcome Header -->
        <div class="kpms-welcome">
            <?php
            $logo_url = home_url('/wp-content/uploads/2026/02/Kamal-Public-School-2.png');
            ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="KPMS Logo" class="kpms-welcome-logo">
            <div class="kpms-welcome-text">
                <h1>Welcome, <?php echo esc_html($current_user->display_name); ?>!</h1>
                <p><?php echo esc_html(date_i18n('l, F j, Y')); ?></p>
            </div>
            <span class="kpms-welcome-badge">KPMS Staff Portal</span>
        </div>

        <!-- Quick Action Cards -->
        <div class="kpms-cards">

            <!-- 1. Update Photos -->
            <div class="kpms-card">
                <div class="kpms-card-header" onclick="kpmsToggleCard(this)">
                    <h2><span class="dashicons dashicons-format-gallery"></span> Update Photos</h2>
                    <button class="kpms-card-toggle" type="button">&#9660;</button>
                </div>
                <div class="kpms-card-body">
                    <button type="button" class="kpms-btn kpms-btn-primary" id="kpms-upload-btn">
                        <span class="dashicons dashicons-upload" style="font-size:16px;width:16px;height:16px;"></span> Upload Photos
                    </button>
                    <div class="kpms-msg" id="kpms-upload-msg"></div>
                    <div class="kpms-upload-grid" id="kpms-upload-grid">
                        <!-- Populated via JS -->
                    </div>
                </div>
            </div>

            <!-- 2. Visual Section Image Manager -->
            <div class="kpms-card" style="grid-column: 1 / -1;">
                <div class="kpms-card-header" onclick="kpmsToggleCard(this)">
                    <h2><span class="dashicons dashicons-format-image"></span> Website Image Manager</h2>
                    <button class="kpms-card-toggle" type="button">&#9660;</button>
                </div>
                <div class="kpms-card-body">
                    <p style="color:#666;font-size:13px;margin-bottom:16px;">Click any image slot to change it. Changes appear on the live website immediately.</p>
                    <div class="kpms-msg" id="kpms-img-msg"></div>
                    <?php
                    $image_sections = [
                        'Hero & Background' => [
                            ['slug' => 'hero_bg', 'label' => 'Hero Background', 'default' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=85'],
                        ],
                        'Feature Cards' => [
                            ['slug' => 'feature_philosophy', 'label' => 'Philosophy Card', 'default' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=700&q=80'],
                            ['slug' => 'feature_faculty', 'label' => 'Faculty Card', 'default' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=700&q=80'],
                            ['slug' => 'feature_community', 'label' => 'Community Card', 'default' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=700&q=80'],
                        ],
                        'Video Tour' => [
                            ['slug' => 'video_tour', 'label' => 'Video Thumbnail', 'default' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80'],
                            ['slug' => 'video_tour_url', 'label' => 'Tour Video File', 'type' => 'video'],
                        ],
                        'Campus Gallery' => [
                            ['slug' => 'gallery_morning_assembly', 'label' => 'Morning Assembly', 'default' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=900&q=80'],
                            ['slug' => 'gallery_library', 'label' => 'Library', 'default' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80'],
                            ['slug' => 'gallery_classrooms', 'label' => 'Classrooms', 'default' => 'https://images.unsplash.com/photo-1588075592446-265fd1e6e76f?w=600&q=80'],
                            ['slug' => 'gallery_art_studio', 'label' => 'Art Studio', 'default' => 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&q=80'],
                            ['slug' => 'gallery_outdoor_learning', 'label' => 'Outdoor Learning', 'default' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=600&q=80'],
                            ['slug' => 'gallery_play_area', 'label' => 'Play & Recreation', 'default' => 'https://images.unsplash.com/photo-1564429238961-bf8eada3e2e6?w=900&q=80'],
                        ],
                        'News Cards' => [
                            ['slug' => 'news_card_1', 'label' => 'News Image 1', 'default' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=600&q=80'],
                            ['slug' => 'news_card_2', 'label' => 'News Image 2', 'default' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&q=80'],
                            ['slug' => 'news_card_3', 'label' => 'News Image 3', 'default' => 'https://images.unsplash.com/photo-1516627145497-ae6968895b74?w=600&q=80'],
                        ],
                        'Campus Tour' => [
                            ['slug' => 'campus_main', 'label' => 'Main Campus Photo', 'default' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1200&q=80'],
                        ],
                    ];
                    foreach ($image_sections as $group_name => $slots): ?>
                    <div class="kpms-img-group">
                        <div class="kpms-img-group-header" onclick="this.parentElement.classList.toggle('collapsed')">
                            <strong><?php echo esc_html($group_name); ?></strong>
                            <span class="kpms-img-group-count"><?php echo count($slots); ?> item<?php echo count($slots) > 1 ? 's' : ''; ?></span>
                        </div>
                        <div class="kpms-img-group-body">
                            <div class="kpms-img-slots">
                                <?php foreach ($slots as $slot):
                                    $current_url = get_option('kpms_section_image_' . $slot['slug'], '');
                                    $is_video = !empty($slot['type']) && $slot['type'] === 'video';
                                    if ($is_video):
                                        $video_filename = $current_url ? basename(parse_url($current_url, PHP_URL_PATH)) : '';
                                ?>
                                <div class="kpms-video-slot" data-slug="<?php echo esc_attr($slot['slug']); ?>">
                                    <div class="kpms-video-info">
                                        <span class="dashicons dashicons-video-alt3" style="color:#2271b1;margin-right:6px;"></span>
                                        <span class="kpms-video-filename"><?php echo $video_filename ? esc_html($video_filename) : '<em>No video selected</em>'; ?></span>
                                    </div>
                                    <div class="kpms-img-label"><?php echo esc_html($slot['label']); ?></div>
                                    <div style="display:flex;gap:6px;margin-top:6px;">
                                        <button type="button" class="kpms-btn kpms-btn-primary kpms-btn-sm kpms-video-choose">Choose Video</button>
                                        <?php if (!empty($current_url)): ?>
                                        <button type="button" class="kpms-btn kpms-btn-danger kpms-btn-sm kpms-video-remove">Remove</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php else:
                                    $display_url = !empty($current_url) ? $current_url : $slot['default'];
                                ?>
                                <div class="kpms-img-slot" data-slug="<?php echo esc_attr($slot['slug']); ?>" data-default="<?php echo esc_attr($slot['default']); ?>">
                                    <div class="kpms-img-preview">
                                        <img src="<?php echo esc_url($display_url); ?>" alt="<?php echo esc_attr($slot['label']); ?>">
                                        <div class="kpms-img-overlay">
                                            <span class="dashicons dashicons-camera"></span>
                                        </div>
                                    </div>
                                    <div class="kpms-img-label"><?php echo esc_html($slot['label']); ?></div>
                                    <?php if (!empty($current_url)): ?>
                                    <button class="kpms-img-reset" title="Reset to default">&times;</button>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- 3. Post Announcement -->
            <div class="kpms-card">
                <div class="kpms-card-header" onclick="kpmsToggleCard(this)">
                    <h2><span class="dashicons dashicons-megaphone"></span> Post Announcement</h2>
                    <button class="kpms-card-toggle" type="button">&#9660;</button>
                </div>
                <div class="kpms-card-body">
                    <div class="kpms-msg" id="kpms-ann-msg"></div>
                    <form id="kpms-announcement-form">
                        <input type="hidden" name="id" value="0">
                        <div class="kpms-form-group">
                            <label>Title</label>
                            <input type="text" name="title" required>
                        </div>
                        <div class="kpms-form-group">
                            <label>Message</label>
                            <textarea name="message" rows="3" required></textarea>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Priority</label>
                                <div class="kpms-radio-group">
                                    <label><input type="radio" name="priority" value="normal" checked> Normal</label>
                                    <label><input type="radio" name="priority" value="important"> Important</label>
                                    <label><input type="radio" name="priority" value="urgent"> Urgent</label>
                                </div>
                            </div>
                            <div class="kpms-form-group">
                                <label>Expires (optional)</label>
                                <input type="date" name="expires_at" value="">
                            </div>
                        </div>
                        <button type="submit" class="kpms-btn kpms-btn-primary">Post Announcement</button>
                        <button type="button" class="kpms-btn kpms-btn-cancel kpms-btn-sm" id="kpms-ann-cancel" style="display:none;">Cancel Edit</button>
                    </form>
                    <div class="kpms-item-list" id="kpms-announcements-list">
                        <?php if (empty($my_announcements)): ?>
                            <p style="color:#999;font-size:13px;">No announcements yet.</p>
                        <?php else: ?>
                            <?php foreach ($my_announcements as $ann): ?>
                            <div class="kpms-item" data-id="<?php echo intval($ann->id); ?>">
                                <div class="kpms-item-info">
                                    <h4><?php echo esc_html($ann->title); ?> <span class="kpms-badge kpms-badge-<?php echo esc_attr($ann->priority); ?>"><?php echo esc_html($ann->priority); ?></span></h4>
                                    <p><?php echo esc_html(wp_trim_words($ann->message, 15)); ?> &mdash; <?php echo esc_html(date('M j, Y', strtotime($ann->created_at))); ?></p>
                                </div>
                                <div class="kpms-item-actions">
                                    <button class="kpms-btn kpms-btn-edit kpms-btn-sm kpms-ann-edit" data-id="<?php echo intval($ann->id); ?>">Edit</button>
                                    <button class="kpms-btn kpms-btn-danger kpms-btn-sm kpms-ann-delete" data-id="<?php echo intval($ann->id); ?>">Delete</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- 4. Update Calendar Events -->
            <div class="kpms-card">
                <div class="kpms-card-header" onclick="kpmsToggleCard(this)">
                    <h2><span class="dashicons dashicons-calendar-alt"></span> Calendar Events</h2>
                    <button class="kpms-card-toggle" type="button">&#9660;</button>
                </div>
                <div class="kpms-card-body">
                    <div class="kpms-msg" id="kpms-event-msg"></div>
                    <form id="kpms-event-form">
                        <input type="hidden" name="id" value="0">
                        <div class="kpms-form-group">
                            <label>Event Name</label>
                            <input type="text" name="event_name" required>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Date</label>
                                <input type="date" name="event_date" required>
                            </div>
                            <div class="kpms-form-group">
                                <label>Time</label>
                                <input type="time" name="event_time">
                            </div>
                        </div>
                        <div class="kpms-form-group">
                            <label>Location</label>
                            <input type="text" name="location">
                        </div>
                        <div class="kpms-form-group">
                            <label>Description</label>
                            <textarea name="description" rows="2"></textarea>
                        </div>
                        <button type="submit" class="kpms-btn kpms-btn-primary">Save Event</button>
                        <button type="button" class="kpms-btn kpms-btn-cancel kpms-btn-sm" id="kpms-event-cancel" style="display:none;">Cancel Edit</button>
                    </form>
                    <div class="kpms-item-list" id="kpms-events-list">
                        <?php if (empty($upcoming_events)): ?>
                            <p style="color:#999;font-size:13px;">No upcoming events.</p>
                        <?php else: ?>
                            <?php foreach ($upcoming_events as $evt): ?>
                            <div class="kpms-item" data-id="<?php echo intval($evt->id); ?>">
                                <div class="kpms-item-info">
                                    <h4><?php echo esc_html($evt->event_name); ?></h4>
                                    <p>
                                        <?php echo esc_html(date('M j, Y', strtotime($evt->event_date))); ?>
                                        <?php if ($evt->event_time): ?> at <?php echo esc_html($evt->event_time); ?><?php endif; ?>
                                        <?php if ($evt->location): ?> &mdash; <?php echo esc_html($evt->location); ?><?php endif; ?>
                                    </p>
                                </div>
                                <div class="kpms-item-actions">
                                    <button class="kpms-btn kpms-btn-edit kpms-btn-sm kpms-event-edit" data-id="<?php echo intval($evt->id); ?>">Edit</button>
                                    <button class="kpms-btn kpms-btn-danger kpms-btn-sm kpms-event-delete" data-id="<?php echo intval($evt->id); ?>">Delete</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- 5. Staff Directory Management -->
            <div class="kpms-card" style="grid-column: 1 / -1;">
                <div class="kpms-card-header" onclick="kpmsToggleCard(this)">
                    <h2><span class="dashicons dashicons-id-alt"></span> Staff Directory</h2>
                    <button class="kpms-card-toggle" type="button">&#9660;</button>
                </div>
                <div class="kpms-card-body">
                    <div class="kpms-msg" id="kpms-staff-msg"></div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;flex-wrap:wrap;gap:10px;">
                        <div class="kpms-staff-tabs">
                            <?php
                            $all_staff = $wpdb->get_results("SELECT * FROM $staff_table WHERE is_active = 1 ORDER BY category ASC, display_order ASC, name ASC");
                            $counts = ['all' => count($all_staff), 'leadership' => 0, 'teaching' => 0, 'support' => 0];
                            foreach ($all_staff as $s) {
                                if (isset($counts[$s->category])) $counts[$s->category]++;
                            }
                            ?>
                            <button class="kpms-tab active" data-cat="all">All <span class="kpms-tab-count"><?php echo $counts['all']; ?></span></button>
                            <button class="kpms-tab" data-cat="leadership">Leadership <span class="kpms-tab-count"><?php echo $counts['leadership']; ?></span></button>
                            <button class="kpms-tab" data-cat="teaching">Teaching <span class="kpms-tab-count"><?php echo $counts['teaching']; ?></span></button>
                            <button class="kpms-tab" data-cat="support">Support <span class="kpms-tab-count"><?php echo $counts['support']; ?></span></button>
                        </div>
                        <button class="kpms-btn kpms-btn-primary" id="kpms-add-staff-btn">
                            <span class="dashicons dashicons-plus-alt" style="font-size:16px;width:16px;height:16px;"></span> Add Staff
                        </button>
                    </div>
                    <div class="kpms-staff-list" id="kpms-staff-list">
                        <?php if (empty($all_staff)): ?>
                            <p style="color:#999;font-size:13px;">No staff members yet.</p>
                        <?php else: ?>
                            <?php foreach ($all_staff as $s):
                                $initials = function_exists('kpms_get_initials') ? kpms_get_initials($s->name) : strtoupper(substr($s->name, 0, 2));
                                $cat_labels = ['leadership' => 'Leadership', 'teaching' => 'Teaching', 'support' => 'Support'];
                                $cat_colors = ['leadership' => '#FFD100', 'teaching' => '#d0e8ff', 'support' => '#d4edda'];
                                $cat_text = ['leadership' => '#003087', 'teaching' => '#003087', 'support' => '#155724'];
                            ?>
                            <div class="kpms-staff-row" data-id="<?php echo intval($s->id); ?>" data-cat="<?php echo esc_attr($s->category); ?>">
                                <div class="kpms-staff-row-info">
                                    <?php if (!empty($s->photo_url)): ?>
                                        <img src="<?php echo esc_url($s->photo_url); ?>" class="kpms-staff-row-avatar" alt="">
                                    <?php else: ?>
                                        <div class="kpms-staff-row-circle" style="background:<?php echo esc_attr($s->circle_color); ?>;color:<?php echo ($s->circle_color === '#FFD100') ? '#003087' : '#fff'; ?>;"><?php echo esc_html($initials); ?></div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?php echo esc_html($s->name); ?><?php if (!empty($s->featured_on_homepage)): ?> <span title="Featured on Homepage" style="color:#FFD100;font-size:14px;">&#11088;</span><?php endif; ?></strong>
                                        <span style="font-size:12px;color:#777;display:block;"><?php echo esc_html($s->title ?: $s->department); ?></span>
                                    </div>
                                </div>
                                <div class="kpms-staff-row-actions">
                                    <span class="kpms-cat-badge" style="background:<?php echo $cat_colors[$s->category] ?? '#eee'; ?>;color:<?php echo $cat_text[$s->category] ?? '#333'; ?>;"><?php echo esc_html($cat_labels[$s->category] ?? $s->category); ?></span>
                                    <button class="kpms-btn kpms-btn-edit kpms-btn-sm kpms-staff-edit" data-id="<?php echo intval($s->id); ?>">Edit</button>
                                    <button class="kpms-btn kpms-btn-danger kpms-btn-sm kpms-staff-delete" data-id="<?php echo intval($s->id); ?>" data-name="<?php echo esc_attr($s->name); ?>">Delete</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Staff Add/Edit Modal -->
            <div class="kpms-modal-overlay" id="kpms-staff-modal-overlay">
                <div class="kpms-modal" style="max-width:600px;">
                    <h3 id="kpms-staff-modal-title">Add Staff Member</h3>
                    <form id="kpms-staff-crud-form">
                        <div class="kpms-msg" id="kpms-staff-modal-msg"></div>
                        <input type="hidden" name="staff_id" value="0">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Full Name *</label>
                                <input type="text" name="name" required>
                            </div>
                            <div class="kpms-form-group">
                                <label>Title / Role</label>
                                <input type="text" name="title" list="kpms-title-list" placeholder="Select or type...">
                                <datalist id="kpms-title-list">
                                    <option value="Principal">
                                    <option value="Vice Principal">
                                    <option value="Head Teacher">
                                    <option value="Senior Teacher">
                                    <option value="Teacher">
                                    <option value="Assistant Teacher">
                                    <option value="Coordinator">
                                    <option value="Librarian">
                                    <option value="Clerk">
                                    <option value="Peon / Attendant">
                                </datalist>
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Category *</label>
                                <select name="category" required>
                                    <option value="leadership">Leadership</option>
                                    <option value="teaching" selected>Teaching Faculty</option>
                                    <option value="support">Support Staff</option>
                                </select>
                            </div>
                            <div class="kpms-form-group">
                                <label>Department / Subject</label>
                                <input type="text" name="department" list="kpms-dept-list" placeholder="Select or type...">
                                <datalist id="kpms-dept-list">
                                    <option value="Mathematics">
                                    <option value="English">
                                    <option value="Urdu">
                                    <option value="Science">
                                    <option value="Islamiat">
                                    <option value="Social Studies">
                                    <option value="Computer Science">
                                    <option value="Art">
                                    <option value="Physical Education">
                                    <option value="Administration">
                                </datalist>
                            </div>
                        </div>
                        <div class="kpms-form-group">
                            <label>Bio / Description</label>
                            <textarea name="bio" rows="3"></textarea>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Qualifications</label>
                                <input type="text" name="qualifications">
                            </div>
                            <div class="kpms-form-group">
                                <label>Personal Quote</label>
                                <input type="text" name="quote">
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr auto;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Display Order</label>
                                <input type="number" name="display_order" value="0" min="0">
                            </div>
                            <div class="kpms-form-group">
                                <label>Circle Color</label>
                                <div class="kpms-color-swatches" id="kpms-color-swatches">
                                    <div class="kpms-swatch active" data-color="#003087" style="background:#003087;" title="Blue"></div>
                                    <div class="kpms-swatch" data-color="#FFD100" style="background:#FFD100;" title="Gold"></div>
                                    <div class="kpms-swatch" data-color="#E8443A" style="background:#E8443A;" title="Red"></div>
                                    <div class="kpms-swatch" data-color="#00B4D8" style="background:#00B4D8;" title="Cyan"></div>
                                    <div class="kpms-swatch" data-color="#0A8F6C" style="background:#0A8F6C;" title="Teal"></div>
                                    <div class="kpms-swatch" data-color="#7B2D8E" style="background:#7B2D8E;" title="Purple"></div>
                                    <div class="kpms-swatch" data-color="#8896a6" style="background:#8896a6;" title="Gray"></div>
                                </div>
                                <input type="hidden" name="circle_color" value="#003087">
                            </div>
                        </div>
                        <div class="kpms-form-group">
                            <label>Photo (optional)</label>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <img id="kpms-staff-modal-photo" src="" alt="" style="width:60px;height:60px;border-radius:50%;object-fit:cover;display:none;border:2px solid #FFD100;">
                                <button type="button" class="kpms-btn kpms-btn-gold kpms-btn-sm" id="kpms-staff-modal-photo-btn">Choose Photo</button>
                                <button type="button" class="kpms-btn kpms-btn-sm" id="kpms-staff-modal-photo-clear" style="display:none;color:#dc3545;">Remove</button>
                                <input type="hidden" name="photo_url" value="">
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <div class="kpms-form-group">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="staff@kpms.edu.pk">
                            </div>
                            <div class="kpms-form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" placeholder="+92-xxx-xxx-xxxx">
                            </div>
                        </div>
                        <div class="kpms-form-group" style="background:#f0f7ff;border:1.5px solid #b8d4f0;border-radius:10px;padding:14px 16px;margin-top:4px;">
                            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;margin:0;font-size:14px;">
                                <input type="checkbox" name="featured_on_homepage" value="1" style="width:18px;height:18px;accent-color:#003087;">
                                <span style="font-size:16px;">&#11088;</span> Feature on Homepage
                            </label>
                            <p style="margin:6px 0 0 34px;font-size:12px;color:#555;">Show this staff member in the "Meet the Educators Who Inspire" section on the homepage.</p>
                        </div>
                        <div class="kpms-modal-actions">
                            <button type="button" class="kpms-btn kpms-btn-cancel" onclick="document.getElementById('kpms-staff-modal-overlay').classList.remove('active')">Cancel</button>
                            <button type="submit" class="kpms-btn kpms-btn-primary">Save Staff Member</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Staff Delete Confirmation Modal -->
            <div class="kpms-modal-overlay" id="kpms-staff-delete-overlay">
                <div class="kpms-modal" style="max-width:420px;text-align:center;">
                    <h3 style="color:#dc3545;">Confirm Deletion</h3>
                    <p style="margin:16px 0;font-size:14px;color:#555;">Are you sure you want to remove <strong id="kpms-staff-delete-name"></strong> from the staff directory?</p>
                    <input type="hidden" id="kpms-staff-delete-id" value="0">
                    <div class="kpms-modal-actions" style="justify-content:center;">
                        <button type="button" class="kpms-btn kpms-btn-cancel" onclick="document.getElementById('kpms-staff-delete-overlay').classList.remove('active')">Cancel</button>
                        <button type="button" class="kpms-btn kpms-btn-danger" id="kpms-staff-delete-confirm" style="padding:10px 22px;font-size:14px;">Delete</button>
                    </div>
                </div>
            </div>

        <!-- Activity Feed -->
        <div class="kpms-feed">
            <?php if ($is_admin): ?>
            <div class="kpms-feed-card">
                <h3>Recent Submissions</h3>
                <?php if (empty($recent_submissions)): ?>
                    <p style="color:#999;font-size:13px;">No submissions yet.</p>
                <?php else: ?>
                    <?php foreach ($recent_submissions as $sub): ?>
                    <div class="kpms-feed-item">
                        <strong><?php echo esc_html($sub->name); ?></strong> &mdash; <?php echo esc_html(ucfirst($sub->form_type)); ?>
                        <div class="kpms-feed-meta"><?php echo esc_html(date('M j, Y g:i A', strtotime($sub->submitted_at))); ?></div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="kpms-feed-card">
                <h3>Recent Announcements</h3>
                <?php if (empty($recent_announcements)): ?>
                    <p style="color:#999;font-size:13px;">No announcements.</p>
                <?php else: ?>
                    <?php foreach ($recent_announcements as $ann): ?>
                    <div class="kpms-feed-item">
                        <strong><?php echo esc_html($ann->title); ?></strong>
                        <span class="kpms-badge kpms-badge-<?php echo esc_attr($ann->priority); ?>" style="margin-left:6px;"><?php echo esc_html($ann->priority); ?></span>
                        <div class="kpms-feed-meta">
                            by <?php echo esc_html($ann->display_name ?: 'Unknown'); ?> &mdash; <?php echo esc_html(date('M j, Y', strtotime($ann->created_at))); ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="kpms-feed-card">
                <h3>Upcoming Events</h3>
                <?php if (empty($feed_events)): ?>
                    <p style="color:#999;font-size:13px;">No upcoming events.</p>
                <?php else: ?>
                    <?php foreach ($feed_events as $evt): ?>
                    <div class="kpms-feed-item">
                        <strong><?php echo esc_html($evt->event_name); ?></strong>
                        <div class="kpms-feed-meta">
                            <?php echo esc_html(date('M j, Y', strtotime($evt->event_date))); ?>
                            <?php if ($evt->event_time): ?> at <?php echo esc_html($evt->event_time); ?><?php endif; ?>
                            <?php if ($evt->location): ?> &mdash; <?php echo esc_html($evt->location); ?><?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Edit Modal (reused for announcements and events) -->
    <div class="kpms-modal-overlay" id="kpms-modal-overlay">
        <div class="kpms-modal" id="kpms-modal">
            <h3 id="kpms-modal-title">Edit</h3>
            <div id="kpms-modal-body"></div>
        </div>
    </div>

    <script>
    (function($) {
        var ajaxUrl = kpmsTeacher.ajax_url;
        var nonce   = kpmsTeacher.nonce;

        // Helpers
        function kpmsAjax(action, data, callback) {
            data.action = action;
            data.nonce  = nonce;
            $.post(ajaxUrl, data, function(resp) {
                callback(resp);
            }).fail(function() {
                callback({success: false, data: 'Network error.'});
            });
        }

        function showMsg(el, msg, type) {
            var $el = $(el);
            $el.removeClass('kpms-msg-success kpms-msg-error').addClass('kpms-msg-' + type).text(msg).show();
            setTimeout(function() { $el.fadeOut(); }, 4000);
        }

        // Card collapse/expand
        window.kpmsToggleCard = function(header) {
            var $body = $(header).next('.kpms-card-body');
            var $btn  = $(header).find('.kpms-card-toggle');
            $body.toggleClass('collapsed');
            $btn.toggleClass('collapsed');
        };

        // ============================================
        // Upload Photos
        // ============================================
        function loadUploads() {
            kpmsAjax('kpms_get_recent_uploads', {}, function(resp) {
                var $grid = $('#kpms-upload-grid');
                $grid.empty();
                if (resp.success && resp.data.length) {
                    $.each(resp.data, function(i, img) {
                        $grid.append(
                            '<div class="kpms-upload-item" data-id="' + img.id + '">' +
                            '<img src="' + img.thumbnail + '" alt="' + img.title + '">' +
                            '<button class="kpms-upload-delete" title="Delete">&times;</button>' +
                            '</div>'
                        );
                    });
                }
            });
        }
        loadUploads();

        $('#kpms-upload-btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Upload Photos',
                multiple: true,
                library: { type: 'image' },
                button: { text: 'Add to Gallery' }
            });
            frame.on('select', function() {
                loadUploads();
                showMsg('#kpms-upload-msg', 'Photos uploaded!', 'success');
            });
            frame.open();
        });

        $(document).on('click', '.kpms-upload-delete', function() {
            if (!confirm('Delete this photo?')) return;
            var $item = $(this).closest('.kpms-upload-item');
            kpmsAjax('kpms_delete_upload', { id: $item.data('id') }, function(resp) {
                if (resp.success) {
                    $item.fadeOut(300, function() { $(this).remove(); });
                } else {
                    alert(resp.data || 'Error deleting.');
                }
            });
        });

        // ============================================
        // Visual Image Manager
        // ============================================
        $(document).on('click', '.kpms-img-preview', function() {
            var $slot = $(this).closest('.kpms-img-slot');
            var slug = $slot.data('slug');
            var frame = wp.media({
                title: 'Choose Image for: ' + $slot.find('.kpms-img-label').text(),
                multiple: false,
                library: { type: 'image' },
                button: { text: 'Use This Image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var url = attachment.sizes && attachment.sizes.large ? attachment.sizes.large.url : attachment.url;
                kpmsAjax('kpms_update_section_image', { section: slug, image_url: url }, function(resp) {
                    if (resp.success) {
                        $slot.find('.kpms-img-preview img').attr('src', url);
                        if (!$slot.find('.kpms-img-reset').length) {
                            $slot.append('<button class="kpms-img-reset" title="Reset to default">&times;</button>');
                        }
                        showMsg('#kpms-img-msg', 'Image updated!', 'success');
                    } else {
                        showMsg('#kpms-img-msg', resp.data || 'Error.', 'error');
                    }
                });
            });
            frame.open();
        });

        $(document).on('click', '.kpms-img-reset', function(e) {
            e.stopPropagation();
            var $slot = $(this).closest('.kpms-img-slot');
            var slug = $slot.data('slug');
            var defaultUrl = $slot.data('default');
            if (!confirm('Reset this image to default?')) return;
            var $btn = $(this);
            kpmsAjax('kpms_update_section_image', { section: slug, image_url: '' }, function(resp) {
                if (resp.success) {
                    $slot.find('.kpms-img-preview img').attr('src', defaultUrl);
                    $btn.remove();
                    showMsg('#kpms-img-msg', 'Image reset to default.', 'success');
                }
            });
        });

        // ============================================
        // Video Upload (Video Tour)
        // ============================================
        $(document).on('click', '.kpms-video-choose', function() {
            var $slot = $(this).closest('.kpms-video-slot');
            var slug = $slot.data('slug');
            var frame = wp.media({
                title: 'Choose Video',
                multiple: false,
                library: { type: 'video' },
                button: { text: 'Use This Video' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var url = attachment.url;
                kpmsAjax('kpms_update_section_image', { section: slug, image_url: url }, function(resp) {
                    if (resp.success) {
                        var fname = url.split('/').pop();
                        $slot.find('.kpms-video-filename').text(fname);
                        if (!$slot.find('.kpms-video-remove').length) {
                            $slot.find('div:last').append('<button type="button" class="kpms-btn kpms-btn-danger kpms-btn-sm kpms-video-remove">Remove</button>');
                        }
                        showMsg('#kpms-img-msg', 'Video updated!', 'success');
                    } else {
                        showMsg('#kpms-img-msg', resp.data || 'Error.', 'error');
                    }
                });
            });
            frame.open();
        });

        $(document).on('click', '.kpms-video-remove', function() {
            var $slot = $(this).closest('.kpms-video-slot');
            var slug = $slot.data('slug');
            if (!confirm('Remove this video? The default video will be used.')) return;
            var $btn = $(this);
            kpmsAjax('kpms_update_section_image', { section: slug, image_url: '' }, function(resp) {
                if (resp.success) {
                    $slot.find('.kpms-video-filename').html('<em>No video selected</em>');
                    $btn.remove();
                    showMsg('#kpms-img-msg', 'Video removed. Default will be used.', 'success');
                }
            });
        });

        // ============================================
        // Announcements
        // ============================================
        var $annForm = $('#kpms-announcement-form');

        $annForm.on('submit', function(e) {
            e.preventDefault();
            var formData = {
                id:         $annForm.find('[name="id"]').val(),
                title:      $annForm.find('[name="title"]').val(),
                message:    $annForm.find('[name="message"]').val(),
                priority:   $annForm.find('[name="priority"]:checked').val(),
                expires_at: $annForm.find('[name="expires_at"]').val()
            };
            kpmsAjax('kpms_save_announcement', formData, function(resp) {
                if (resp.success) {
                    showMsg('#kpms-ann-msg', resp.data.message, 'success');
                    $annForm[0].reset();
                    $annForm.find('[name="id"]').val(0);
                    $('#kpms-ann-cancel').hide();
                    location.reload();
                } else {
                    showMsg('#kpms-ann-msg', resp.data || 'Error.', 'error');
                }
            });
        });

        $(document).on('click', '.kpms-ann-edit', function() {
            var id = $(this).data('id');
            kpmsAjax('kpms_get_announcement', { id: id }, function(resp) {
                if (resp.success) {
                    var d = resp.data;
                    $annForm.find('[name="id"]').val(d.id);
                    $annForm.find('[name="title"]').val(d.title);
                    $annForm.find('[name="message"]').val(d.message);
                    $annForm.find('[name="priority"][value="' + d.priority + '"]').prop('checked', true);
                    $annForm.find('[name="expires_at"]').val(d.expires_at || '');
                    $('#kpms-ann-cancel').show();
                    $annForm.find('[name="title"]').focus();
                }
            });
        });

        $('#kpms-ann-cancel').on('click', function() {
            $annForm[0].reset();
            $annForm.find('[name="id"]').val(0);
            $(this).hide();
        });

        $(document).on('click', '.kpms-ann-delete', function() {
            if (!confirm('Delete this announcement?')) return;
            var $item = $(this).closest('.kpms-item');
            kpmsAjax('kpms_delete_announcement', { id: $(this).data('id') }, function(resp) {
                if (resp.success) {
                    $item.fadeOut(300, function() { $(this).remove(); });
                    showMsg('#kpms-ann-msg', 'Announcement deleted.', 'success');
                } else {
                    showMsg('#kpms-ann-msg', resp.data || 'Error.', 'error');
                }
            });
        });

        // ============================================
        // Events
        // ============================================
        var $evtForm = $('#kpms-event-form');

        $evtForm.on('submit', function(e) {
            e.preventDefault();
            var formData = {
                id:          $evtForm.find('[name="id"]').val(),
                event_name:  $evtForm.find('[name="event_name"]').val(),
                event_date:  $evtForm.find('[name="event_date"]').val(),
                event_time:  $evtForm.find('[name="event_time"]').val(),
                location:    $evtForm.find('[name="location"]').val(),
                description: $evtForm.find('[name="description"]').val()
            };
            kpmsAjax('kpms_save_event', formData, function(resp) {
                if (resp.success) {
                    showMsg('#kpms-event-msg', resp.data.message, 'success');
                    $evtForm[0].reset();
                    $evtForm.find('[name="id"]').val(0);
                    $('#kpms-event-cancel').hide();
                    location.reload();
                } else {
                    showMsg('#kpms-event-msg', resp.data || 'Error.', 'error');
                }
            });
        });

        $(document).on('click', '.kpms-event-edit', function() {
            var id = $(this).data('id');
            kpmsAjax('kpms_get_event', { id: id }, function(resp) {
                if (resp.success) {
                    var d = resp.data;
                    $evtForm.find('[name="id"]').val(d.id);
                    $evtForm.find('[name="event_name"]').val(d.event_name);
                    $evtForm.find('[name="event_date"]').val(d.event_date);
                    $evtForm.find('[name="event_time"]').val(d.event_time);
                    $evtForm.find('[name="location"]').val(d.location);
                    $evtForm.find('[name="description"]').val(d.description);
                    $('#kpms-event-cancel').show();
                    $evtForm.find('[name="event_name"]').focus();
                }
            });
        });

        $('#kpms-event-cancel').on('click', function() {
            $evtForm[0].reset();
            $evtForm.find('[name="id"]').val(0);
            $(this).hide();
        });

        $(document).on('click', '.kpms-event-delete', function() {
            if (!confirm('Delete this event?')) return;
            var $item = $(this).closest('.kpms-item');
            kpmsAjax('kpms_delete_event', { id: $(this).data('id') }, function(resp) {
                if (resp.success) {
                    $item.fadeOut(300, function() { $(this).remove(); });
                    showMsg('#kpms-event-msg', 'Event deleted.', 'success');
                } else {
                    showMsg('#kpms-event-msg', resp.data || 'Error.', 'error');
                }
            });
        });

        // ============================================
        // Staff Directory CRUD
        // ============================================

        // Tab filtering
        $(document).on('click', '.kpms-tab', function() {
            $('.kpms-tab').removeClass('active');
            $(this).addClass('active');
            var cat = $(this).data('cat');
            if (cat === 'all') {
                $('.kpms-staff-row').show();
            } else {
                $('.kpms-staff-row').hide();
                $('.kpms-staff-row[data-cat="' + cat + '"]').show();
            }
        });

        // Open Add modal
        $('#kpms-add-staff-btn').on('click', function() {
            var $form = $('#kpms-staff-crud-form');
            $form[0].reset();
            $form.find('[name="staff_id"]').val(0);
            $form.find('[name="circle_color"]').val('#003087');
            $('.kpms-swatch').removeClass('active');
            $('.kpms-swatch[data-color="#003087"]').addClass('active');
            $('#kpms-staff-modal-photo').hide();
            $('#kpms-staff-modal-photo-clear').hide();
            $form.find('[name="photo_url"]').val('');
            $form.find('[name="email"]').val('');
            $form.find('[name="phone"]').val('');
            $form.find('[name="featured_on_homepage"]').prop('checked', false);
            $('#kpms-staff-modal-title').text('Add Staff Member');
            $('#kpms-staff-modal-overlay').addClass('active');
        });

        // Color swatches
        $(document).on('click', '.kpms-swatch', function() {
            $('.kpms-swatch').removeClass('active');
            $(this).addClass('active');
            $('#kpms-staff-crud-form [name="circle_color"]').val($(this).data('color'));
        });

        // Photo chooser in modal
        $('#kpms-staff-modal-photo-btn').on('click', function(e) {
            e.preventDefault();
            var frame = wp.media({
                title: 'Choose Staff Photo',
                multiple: false,
                library: { type: 'image' },
                button: { text: 'Use This Photo' }
            });
            frame.on('select', function() {
                var att = frame.state().get('selection').first().toJSON();
                var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
                $('#kpms-staff-modal-photo').attr('src', url).show();
                $('#kpms-staff-modal-photo-clear').show();
                $('#kpms-staff-crud-form [name="photo_url"]').val(att.url);
            });
            frame.open();
        });

        $('#kpms-staff-modal-photo-clear').on('click', function() {
            $('#kpms-staff-modal-photo').hide();
            $(this).hide();
            $('#kpms-staff-crud-form [name="photo_url"]').val('');
        });

        // Edit staff
        $(document).on('click', '.kpms-staff-edit', function() {
            var id = $(this).data('id');
            kpmsAjax('kpms_get_staff', { staff_id: id }, function(resp) {
                if (resp.success) {
                    var d = resp.data;
                    var $form = $('#kpms-staff-crud-form');
                    $form.find('[name="staff_id"]').val(d.id);
                    $form.find('[name="name"]').val(d.name);
                    $form.find('[name="title"]').val(d.title);
                    $form.find('[name="category"]').val(d.category);
                    $form.find('[name="department"]').val(d.department);
                    $form.find('[name="bio"]').val(d.bio);
                    $form.find('[name="qualifications"]').val(d.qualifications);
                    $form.find('[name="quote"]').val(d.quote);
                    $form.find('[name="display_order"]').val(d.display_order);
                    $form.find('[name="circle_color"]').val(d.circle_color);
                    $form.find('[name="photo_url"]').val(d.photo_url || '');
                    $form.find('[name="email"]').val(d.email || '');
                    $form.find('[name="phone"]').val(d.phone || '');
                    $form.find('[name="featured_on_homepage"]').prop('checked', parseInt(d.featured_on_homepage) === 1);
                    // Set color swatch
                    $('.kpms-swatch').removeClass('active');
                    var $sw = $('.kpms-swatch[data-color="' + d.circle_color + '"]');
                    if ($sw.length) $sw.addClass('active');
                    // Set photo
                    if (d.photo_url) {
                        $('#kpms-staff-modal-photo').attr('src', d.photo_url).show();
                        $('#kpms-staff-modal-photo-clear').show();
                    } else {
                        $('#kpms-staff-modal-photo').hide();
                        $('#kpms-staff-modal-photo-clear').hide();
                    }
                    $('#kpms-staff-modal-title').text('Edit Staff Member');
                    $('#kpms-staff-modal-overlay').addClass('active');
                }
            });
        });

        // Save staff (create/update)
        $('#kpms-staff-crud-form').on('submit', function(e) {
            e.preventDefault();
            var $f = $(this);
            var formData = {
                staff_id:              $f.find('[name="staff_id"]').val(),
                name:                  $f.find('[name="name"]').val(),
                title:                 $f.find('[name="title"]').val(),
                category:              $f.find('[name="category"]').val(),
                department:            $f.find('[name="department"]').val(),
                bio:                   $f.find('[name="bio"]').val(),
                qualifications:        $f.find('[name="qualifications"]').val(),
                quote:                 $f.find('[name="quote"]').val(),
                display_order:         $f.find('[name="display_order"]').val(),
                circle_color:          $f.find('[name="circle_color"]').val(),
                photo_url:             $f.find('[name="photo_url"]').val(),
                featured_on_homepage:  $f.find('[name="featured_on_homepage"]').is(':checked') ? 1 : 0,
                email:                 $f.find('[name="email"]').val(),
                phone:                 $f.find('[name="phone"]').val()
            };
            kpmsAjax('kpms_save_staff', formData, function(resp) {
                if (resp.success) {
                    $('#kpms-staff-modal-overlay').removeClass('active');
                    showMsg('#kpms-staff-msg', resp.data.message, 'success');
                    setTimeout(function() { location.reload(); }, 600);
                } else {
                    showMsg('#kpms-staff-modal-msg', resp.data || 'Error saving staff member.', 'error');
                }
            });
        });

        // Delete staff
        $(document).on('click', '.kpms-staff-delete', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            $('#kpms-staff-delete-id').val(id);
            $('#kpms-staff-delete-name').text(name);
            $('#kpms-staff-delete-overlay').addClass('active');
        });

        $('#kpms-staff-delete-confirm').on('click', function() {
            var id = $('#kpms-staff-delete-id').val();
            kpmsAjax('kpms_delete_staff', { staff_id: id }, function(resp) {
                if (resp.success) {
                    showMsg('#kpms-staff-msg', resp.data.message, 'success');
                    $('#kpms-staff-delete-overlay').removeClass('active');
                    setTimeout(function() { location.reload(); }, 600);
                } else {
                    showMsg('#kpms-staff-msg', resp.data || 'Error.', 'error');
                }
            });
        });

        // Modal close on overlay click
        $(document).on('click', '.kpms-modal-overlay', function(e) {
            if (e.target === this) {
                $(this).removeClass('active');
            }
        });

    })(jQuery);
    </script>
    <?php
}
