<?php
/**
 * KPMS WordPress Installer - Lightweight version
 * DELETE THIS FILE AFTER USE
 */
ini_set('display_errors', 1);
ini_set('max_execution_time', 300);
ini_set('memory_limit', '256M');
error_reporting(E_ALL);

header('Content-Type: text/plain; charset=utf-8');

$SECRET = 'kpms2026install';
if (!isset($_GET['key']) || $_GET['key'] !== $SECRET) {
    die("Append ?key=$SECRET&step=1");
}

$step = isset($_GET['step']) ? (int)$_GET['step'] : 0;
$dir = __DIR__;

// ========== STEP 1: Download WordPress ==========
if ($step === 1) {
    echo "STEP 1: Download WordPress\n\n";

    if (file_exists("$dir/wp-load.php")) {
        echo "WordPress files already exist. Go to step 2.\n";
        echo "?key=$SECRET&step=2\n";
        exit;
    }

    $tmp = "$dir/wp-latest.zip";
    $url = 'https://wordpress.org/latest.zip';

    echo "Downloading $url ...\n";

    $ch = curl_init($url);
    $fp = fopen($tmp, 'w');
    curl_setopt_array($ch, [
        CURLOPT_FILE => $fp,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 180,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $ok = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);
    fclose($fp);

    if (!$ok || $code !== 200 || filesize($tmp) < 1000000) {
        echo "Download failed. HTTP: $code, Error: $err\n";
        @unlink($tmp);
        exit;
    }

    echo "Downloaded: " . round(filesize($tmp)/1048576, 1) . " MB\n\n";

    echo "Extracting ZIP...\n";
    $zip = new ZipArchive();
    if ($zip->open($tmp) === true) {
        $zip->extractTo($dir);
        $zip->close();
        echo "Extracted successfully.\n\n";
    } else {
        echo "ZIP extraction failed. Try shell...\n";
        exec("cd '$dir' && unzip -o '$tmp' 2>&1", $out, $ret);
        echo implode("\n", $out) . "\n";
        if ($ret !== 0) {
            echo "Extraction failed.\n";
            exit;
        }
    }

    @unlink($tmp);

    // Move files from wordpress/ to public_html/
    echo "Moving files from wordpress/ to web root...\n";
    $wp_sub = "$dir/wordpress";
    if (is_dir($wp_sub)) {
        $count = 0;
        $iter = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($wp_sub, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iter as $item) {
            $rel = $iter->getSubPathName();
            $target = "$dir/$rel";
            // Don't overwrite our theme
            if (strpos($rel, 'wp-content/themes/kpms-redesign') === 0) continue;
            if ($item->isDir()) {
                if (!is_dir($target)) @mkdir($target, 0755, true);
            } else {
                @copy($item->getPathname(), $target);
                $count++;
            }
        }
        echo "Moved $count files.\n";

        // Cleanup wordpress/ dir (no exec available)
        $cleanup = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($wp_sub, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($cleanup as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($wp_sub);
        echo "Cleaned up wordpress/ directory.\n";
    }

    // Remove placeholder
    if (file_exists("$dir/index.html")) {
        unlink("$dir/index.html");
        echo "Removed default index.html\n";
    }

    echo "\nDone! WordPress files installed.\n";
    echo "\nNEXT: Create a MySQL database in cPanel:\n";
    echo "  1. Go to cPanel > MySQL Databases\n";
    echo "  2. Create database: kpmsedup_wp\n";
    echo "  3. Create user: kpmsedup_wp with a password\n";
    echo "  4. Add user to database with ALL PRIVILEGES\n";
    echo "  5. Then run: ?key=$SECRET&step=2&dbname=kpmsedup_wp&dbuser=kpmsedup_wp&dbpass=YOUR_PASSWORD\n";
    exit;
}

// ========== STEP 2: Create wp-config.php ==========
if ($step === 2) {
    echo "STEP 2: Configure wp-config.php\n\n";

    $dbname = isset($_GET['dbname']) ? $_GET['dbname'] : '';
    $dbuser = isset($_GET['dbuser']) ? $_GET['dbuser'] : '';
    $dbpass = isset($_GET['dbpass']) ? $_GET['dbpass'] : '';

    if (empty($dbname) || empty($dbuser)) {
        echo "Provide DB credentials:\n";
        echo "?key=$SECRET&step=2&dbname=NAME&dbuser=USER&dbpass=PASS\n";
        exit;
    }

    // Test connection
    echo "Testing database connection...\n";
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
        echo "Connected OK!\n\n";
    } catch (PDOException $e) {
        echo "FAILED: " . $e->getMessage() . "\n";
        exit;
    }

    // Get salts
    $salts = @file_get_contents('https://api.wordpress.org/secret-key/1.1/salt/');
    if (!$salts) {
        $salts = '';
        foreach (['AUTH_KEY','SECURE_AUTH_KEY','LOGGED_IN_KEY','NONCE_KEY','AUTH_SALT','SECURE_AUTH_SALT','LOGGED_IN_SALT','NONCE_SALT'] as $k) {
            $v = bin2hex(random_bytes(32));
            $salts .= "define('$k', '$v');\n";
        }
    }

    $config = "<?php\ndefine('DB_NAME', '$dbname');\ndefine('DB_USER', '$dbuser');\ndefine('DB_PASSWORD', '$dbpass');\ndefine('DB_HOST', 'localhost');\ndefine('DB_CHARSET', 'utf8mb4');\ndefine('DB_COLLATE', '');\n\n$salts\n\$table_prefix = 'wp_';\ndefine('WP_DEBUG', false);\ndefine('WP_MEMORY_LIMIT', '256M');\n\nif (!defined('ABSPATH')) define('ABSPATH', __DIR__ . '/');\nrequire_once ABSPATH . 'wp-settings.php';\n";

    file_put_contents("$dir/wp-config.php", $config);
    echo "wp-config.php created!\n\n";
    echo "NEXT: ?key=$SECRET&step=3\n";
    exit;
}

// ========== STEP 3: Install WordPress ==========
if ($step === 3) {
    echo "STEP 3: Install WordPress\n\n";

    if (!file_exists("$dir/wp-config.php")) {
        echo "Run step 2 first.\n";
        exit;
    }

    define('ABSPATH', "$dir/");
    define('WP_INSTALLING', true);
    @require_once ABSPATH . 'wp-load.php';
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    if (is_blog_installed()) {
        echo "Already installed! Go to step 4.\n";
        echo "?key=$SECRET&step=4\n";
        exit;
    }

    $user = 'kpms_admin';
    $pass = substr(bin2hex(random_bytes(8)), 0, 16);
    $email = 'kpmsabbottabad@gmail.com';

    $result = wp_install('Kamal Public Middle School', $user, $email, true, '', $pass, 'en_US');

    if (is_wp_error($result)) {
        echo "ERROR: " . $result->get_error_message() . "\n";
        exit;
    }

    update_option('siteurl', 'https://kpms.edu.pk');
    update_option('home', 'https://kpms.edu.pk');
    update_option('blogdescription', 'Nurturing Young Minds Since 1985');

    echo "=== WORDPRESS INSTALLED ===\n\n";
    echo "SAVE THESE CREDENTIALS:\n";
    echo "  URL:      https://kpms.edu.pk/wp-admin/\n";
    echo "  Username: $user\n";
    echo "  Password: $pass\n";
    echo "  Email:    $email\n\n";
    echo "NEXT: ?key=$SECRET&step=4&wpuser=$user&wppass=$pass\n";
    exit;
}

// ========== STEP 4: Activate theme & create pages ==========
if ($step === 4) {
    echo "STEP 4: Activate theme & create pages\n\n";

    define('ABSPATH', "$dir/");
    define('WP_USE_THEMES', false);
    @require_once ABSPATH . 'wp-load.php';
    require_once ABSPATH . 'wp-admin/includes/theme.php';

    // Activate theme
    echo "[1] Activating kpms-redesign theme...\n";
    $current = get_stylesheet();
    if ($current === 'kpms-redesign') {
        echo "    Already active!\n";
    } else {
        switch_theme('kpms-redesign');
        echo "    " . (get_stylesheet() === 'kpms-redesign' ? 'Activated!' : 'FAILED') . "\n";
    }

    // Create pages
    echo "\n[2] Creating pages...\n";
    $pages = [
        ['Home',            'home',            'kpms-homepage.php'],
        ['Parent Portal',   'parent-portal',   'page-parent-portal.php'],
        ['School Calendar', 'calendar',        'page-calendar.php'],
        ['Lunch Menu',      'lunch-menu',      'page-lunch-menu.php'],
        ['Enrollment',      'enrollment',      'page-enrollment.php'],
        ['Staff Directory', 'staff-directory', 'page-staff-directory.php'],
        ['Contact Us',      'contact',         'page-contact.php'],
    ];

    $home_id = 0;
    foreach ($pages as $p) {
        $existing = get_page_by_path($p[1]);
        if ($existing) {
            $id = $existing->ID;
            update_post_meta($id, '_wp_page_template', $p[2]);
            echo "    EXISTS: {$p[0]} (ID:$id) -> {$p[2]}\n";
        } else {
            $id = wp_insert_post([
                'post_type' => 'page', 'post_title' => $p[0],
                'post_name' => $p[1], 'post_status' => 'publish',
            ]);
            update_post_meta($id, '_wp_page_template', $p[2]);
            echo "    CREATED: {$p[0]} (ID:$id) -> {$p[2]}\n";
        }
        if ($p[1] === 'home') $home_id = $id;
    }

    // Set homepage
    echo "\n[3] Setting static homepage...\n";
    update_option('show_on_front', 'page');
    update_option('page_on_front', $home_id);
    echo "    Homepage = Home (ID:$home_id)\n";

    // Set permalinks
    echo "\n[4] Setting permalinks to /%postname%/...\n";
    global $wp_rewrite;
    $wp_rewrite->set_permalink_structure('/%postname%/');
    $wp_rewrite->flush_rules(true);
    echo "    Done!\n";

    // Cleanup defaults
    echo "\n[5] Cleaning up defaults...\n";
    $hello = get_page_by_path('hello-world', OBJECT, 'post');
    if ($hello) { wp_delete_post($hello->ID, true); echo "    Deleted Hello World post\n"; }
    $sample = get_page_by_path('sample-page');
    if ($sample) { wp_delete_post($sample->ID, true); echo "    Deleted Sample Page\n"; }

    echo "\n=== ALL DONE! ===\n\n";
    echo "Site: https://kpms.edu.pk/\n";
    echo "Pages:\n";
    echo "  / (Homepage)\n  /parent-portal/\n  /calendar/\n";
    echo "  /lunch-menu/\n  /enrollment/\n  /staff-directory/\n  /contact/\n";
    echo "\nDELETE kpms-installer.php from the server NOW!\n";
    exit;
}

echo "Steps:\n";
echo "  ?key=$SECRET&step=1 - Download WordPress\n";
echo "  ?key=$SECRET&step=2 - Configure database\n";
echo "  ?key=$SECRET&step=3 - Install WordPress\n";
echo "  ?key=$SECRET&step=4 - Activate theme & pages\n";
