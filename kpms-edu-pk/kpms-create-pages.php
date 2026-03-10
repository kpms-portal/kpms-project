<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');
$SECRET = 'kpms2026install';
if (!isset($_GET['key']) || $_GET['key'] !== $SECRET) die("Append ?key=$SECRET");
define('ABSPATH', __DIR__ . '/');
define('WP_USE_THEMES', false);
@require_once ABSPATH . 'wp-load.php';

$pages = [
    ['Mission & Vision', 'mission-vision', 'page-mission-vision.php'],
];

foreach ($pages as $p) {
    $existing = get_page_by_path($p[1]);
    if ($existing) {
        $id = $existing->ID;
        update_post_meta($id, '_wp_page_template', $p[2]);
        echo "EXISTS: {$p[0]} (ID:$id) -> {$p[2]}\n";
    } else {
        $id = wp_insert_post([
            'post_type' => 'page',
            'post_title' => $p[0],
            'post_name' => $p[1],
            'post_status' => 'publish',
        ]);
        if (is_wp_error($id)) { echo "ERROR: " . $id->get_error_message() . "\n"; continue; }
        update_post_meta($id, '_wp_page_template', $p[2]);
        echo "CREATED: {$p[0]} (ID:$id) -> {$p[2]}\n";
    }
}
echo "\nDone! DELETE this file.\n";
