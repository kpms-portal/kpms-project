<?php
/**
 * KPMS Database Setup Helper
 * Creates MySQL database via cPanel XML API (local)
 * DELETE AFTER USE
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/plain; charset=utf-8');

$SECRET = 'kpms2026install';
if (!isset($_GET['key']) || $_GET['key'] !== $SECRET) {
    die("Append ?key=$SECRET");
}

$cpanel_user = 'kpmsedup';
$cpanel_pass = 'r.le8WGv34]6QC';
$db_suffix = 'wp';
$db_name = $cpanel_user . '_' . $db_suffix;
$db_user = $cpanel_user . '_' . $db_suffix;
$db_pass = bin2hex(random_bytes(10));

echo "=== KPMS Database Setup ===\n\n";

// Try cPanel UAPI via localhost
function cpanel_api($module, $func, $params = []) {
    global $cpanel_user, $cpanel_pass;

    $query = http_build_query($params);
    $url = "https://127.0.0.1:2083/execute/$module/$func?$query";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "$cpanel_user:$cpanel_pass",
        CURLOPT_TIMEOUT => 15,
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    return ['code' => $code, 'body' => $res, 'error' => $err, 'parsed' => json_decode($res, true)];
}

// Try cPanel JSON API v2 via localhost
function cpanel_api2($module, $func, $params = []) {
    global $cpanel_user, $cpanel_pass;

    $params['cpanel_jsonapi_module'] = $module;
    $params['cpanel_jsonapi_func'] = $func;
    $params['cpanel_jsonapi_apiversion'] = '2';
    $params['cpanel_jsonapi_user'] = $cpanel_user;
    $query = http_build_query($params);
    $url = "https://127.0.0.1:2083/json-api/cpanel?$query";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => "$cpanel_user:$cpanel_pass",
        CURLOPT_TIMEOUT => 15,
    ]);
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    return ['code' => $code, 'body' => $res, 'error' => $err, 'parsed' => json_decode($res, true)];
}

echo "Attempting to create database: $db_name\n";
echo "Attempting to create user: $db_user\n\n";

// Method 1: UAPI
echo "--- Method 1: UAPI ---\n";
$r = cpanel_api('Mysql', 'create_database', ['name' => $db_name]);
echo "Create DB: HTTP {$r['code']}, Error: {$r['error']}\n";
if ($r['parsed']) echo "Response: " . json_encode($r['parsed'], JSON_PRETTY_PRINT) . "\n";
else echo "Raw: " . substr($r['body'], 0, 500) . "\n";

$r2 = cpanel_api('Mysql', 'create_user', ['name' => $db_user, 'password' => $db_pass]);
echo "\nCreate User: HTTP {$r2['code']}\n";
if ($r2['parsed']) echo "Response: " . json_encode($r2['parsed'], JSON_PRETTY_PRINT) . "\n";
else echo "Raw: " . substr($r2['body'], 0, 500) . "\n";

$r3 = cpanel_api('Mysql', 'set_privileges_on_database', [
    'user' => $db_user, 'database' => $db_name, 'privileges' => 'ALL PRIVILEGES'
]);
echo "\nGrant Privileges: HTTP {$r3['code']}\n";
if ($r3['parsed']) echo "Response: " . json_encode($r3['parsed'], JSON_PRETTY_PRINT) . "\n";
else echo "Raw: " . substr($r3['body'], 0, 500) . "\n";

// Test if it worked
echo "\n--- Testing Connection ---\n";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_pass);
    echo "SUCCESS! Database connection works!\n\n";
    echo "=== DATABASE CREDENTIALS ===\n";
    echo "DB Name: $db_name\n";
    echo "DB User: $db_user\n";
    echo "DB Pass: $db_pass\n";
    echo "DB Host: localhost\n";
    echo "============================\n\n";
    echo "Now run the installer step 2:\n";
    echo "kpms-installer.php?key=$SECRET&step=2&dbname=$db_name&dbuser=$db_user&dbpass=$db_pass\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n\n";

    // Method 2: Try JSON API v2
    echo "--- Method 2: JSON API v2 ---\n";
    $r = cpanel_api2('MysqlFE', 'createdb', ['db' => $db_name]);
    echo "Create DB: HTTP {$r['code']}\n";
    if ($r['parsed']) echo "Response: " . json_encode($r['parsed'], JSON_PRETTY_PRINT) . "\n";
    else echo "Raw: " . substr($r['body'], 0, 500) . "\n";

    $r2 = cpanel_api2('MysqlFE', 'createdbuser', ['dbuser' => $db_user, 'dbuserpw' => $db_pass]);
    echo "\nCreate User: HTTP {$r2['code']}\n";
    if ($r2['parsed']) echo "Response: " . json_encode($r2['parsed'], JSON_PRETTY_PRINT) . "\n";

    $r3 = cpanel_api2('MysqlFE', 'setdbuserprivileges', [
        'db' => $db_name, 'dbuser' => $db_user, 'privileges' => 'ALL PRIVILEGES'
    ]);
    echo "\nGrant: HTTP {$r3['code']}\n";
    if ($r3['parsed']) echo "Response: " . json_encode($r3['parsed'], JSON_PRETTY_PRINT) . "\n";

    // Test again
    try {
        $pdo2 = new PDO("mysql:host=localhost;dbname=$db_name", $db_user, $db_pass);
        echo "\nSUCCESS on second attempt!\n";
        echo "DB Name: $db_name\nDB User: $db_user\nDB Pass: $db_pass\n";
    } catch (PDOException $e2) {
        echo "\nStill failed: " . $e2->getMessage() . "\n\n";
        echo "=== MANUAL DATABASE SETUP REQUIRED ===\n";
        echo "Go to cPanel > MySQL Databases and:\n";
        echo "  1. Create database: $db_name\n";
        echo "  2. Create user: $db_user (choose a password)\n";
        echo "  3. Add user to database with ALL PRIVILEGES\n";
        echo "  4. Then run installer step 2 with your chosen password\n";
    }
}
