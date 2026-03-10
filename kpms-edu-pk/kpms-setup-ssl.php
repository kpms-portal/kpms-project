<?php
/**
 * KPMS SSL + Password Setup Helper
 * Runs on the server to request Let's Encrypt SSL via DirectAdmin API
 * and change the WordPress admin password.
 * DELETE THIS FILE AFTER USE.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

$SECRET = 'kpms2026install';
if (!isset($_GET['key']) || $_GET['key'] !== $SECRET) {
    die("Append ?key=$SECRET&action=ssl or &action=password or &action=both");
}

$action = isset($_GET['action']) ? $_GET['action'] : 'both';
$da_user = 'kpmsedup';
$da_pass = 'r.le8WGv34]6QC';
$domain  = 'kpms.edu.pk';

// ========== SSL SETUP ==========
if ($action === 'ssl' || $action === 'both') {
    echo "=== SSL CERTIFICATE SETUP ===\n\n";

    // Try DirectAdmin Let's Encrypt API via localhost:2222
    $ports = [2222, 2083];
    $success = false;

    foreach ($ports as $port) {
        echo "Trying DirectAdmin on port $port...\n";

        $post_data = http_build_query([
            'domain'       => $domain,
            'action'       => 'obtain',
            'type'         => 'create',
            'name'         => $domain,
            'keysize'      => 'ec-384',
            'encryption'   => 'sha256',
            'le_select0'   => $domain,
            'le_select1'   => 'www.' . $domain,
            'le_wc_select0'=> $domain,
        ]);

        $ch = curl_init("https://127.0.0.1:$port/CMD_API_LETSENCRYPT");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => "$da_user:$da_pass",
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post_data,
            CURLOPT_TIMEOUT        => 120,
        ]);
        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        echo "  HTTP: $code\n";
        if ($err) echo "  cURL error: $err\n";

        if ($code === 200 || $code === 301 || $code === 302) {
            echo "  Response: " . substr($res, 0, 1500) . "\n";

            // Check for success indicators
            if (strpos($res, 'error=0') !== false || strpos($res, 'Certificate.*saved') !== false || ($code === 200 && strpos($res, 'error') === false)) {
                echo "\n  SSL certificate request appears successful!\n";
                $success = true;
                break;
            } elseif (strpos($res, 'error=1') !== false) {
                echo "\n  Error in response. Trying next method...\n";
            } else {
                echo "\n  Got a response. Checking...\n";
                $success = true;
                break;
            }
        }
        echo "\n";
    }

    // Also try the newer DirectAdmin SSL endpoint
    if (!$success) {
        echo "Trying CMD_SSL on port 2222...\n";
        $post_ssl = http_build_query([
            'domain'  => $domain,
            'action'  => 'save',
            'type'    => 'letsencrypt',
            'request' => 'yes',
        ]);

        $ch = curl_init("https://127.0.0.1:2222/CMD_SSL");
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_USERPWD        => "$da_user:$da_pass",
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $post_ssl,
            CURLOPT_TIMEOUT        => 60,
        ]);
        $res  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        echo "  HTTP: $code\n";
        if ($err) echo "  cURL error: $err\n";
        echo "  Response: " . substr($res, 0, 1500) . "\n\n";
    }

    // Try to force HTTPS redirect via .htaccess
    echo "\n--- Setting up HTTPS redirect in .htaccess ---\n";
    $htaccess_path = __DIR__ . '/.htaccess';
    $htaccess = file_exists($htaccess_path) ? file_get_contents($htaccess_path) : '';

    $https_rules = "\n# Force HTTPS\nRewriteEngine On\nRewriteCond %{HTTPS} off\nRewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\n";

    if (strpos($htaccess, 'Force HTTPS') === false) {
        // Prepend HTTPS rules before WordPress rules
        if (strpos($htaccess, '# BEGIN WordPress') !== false) {
            $htaccess = $https_rules . "\n" . $htaccess;
        } else {
            $htaccess = $https_rules . "\n" . $htaccess;
        }
        file_put_contents($htaccess_path, $htaccess);
        echo "  HTTPS redirect added to .htaccess\n";
    } else {
        echo "  HTTPS redirect already in .htaccess\n";
    }

    echo "\n";
}

// ========== PASSWORD CHANGE ==========
if ($action === 'password' || $action === 'both') {
    echo "=== WORDPRESS PASSWORD CHANGE ===\n\n";

    // Generate strong password
    $new_pass = substr(str_replace(['+','/','='], '', base64_encode(random_bytes(16))), 0, 20);

    // Load WordPress
    define('ABSPATH', __DIR__ . '/');
    define('WP_USE_THEMES', false);
    @require_once ABSPATH . 'wp-load.php';

    $user = get_user_by('login', 'kpms_admin');
    if ($user) {
        wp_set_password($new_pass, $user->ID);

        // Also update site URLs to HTTPS
        update_option('siteurl', 'https://kpms.edu.pk');
        update_option('home', 'https://kpms.edu.pk');
        echo "Site URLs updated to HTTPS.\n\n";

        echo "Password changed successfully!\n\n";
        echo "=== NEW CREDENTIALS ===\n";
        echo "  URL:      https://kpms.edu.pk/wp-admin/\n";
        echo "  Username: kpms_admin\n";
        echo "  Password: $new_pass\n";
        echo "  Email:    kpmsabbottabad@gmail.com\n";
        echo "========================\n\n";
        echo "SAVE THIS PASSWORD NOW!\n";
    } else {
        echo "ERROR: User 'kpms_admin' not found.\n";
        // List users
        $users = get_users(['role' => 'administrator']);
        echo "Admin users found:\n";
        foreach ($users as $u) {
            echo "  - {$u->user_login} (ID: {$u->ID})\n";
        }
    }

    echo "\n";
}

echo "=== DONE ===\n";
echo "DELETE this file (kpms-setup-ssl.php) from the server NOW!\n";
