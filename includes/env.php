<?php
// Environment detection
$isLocal = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1');

// Database config
if ($isLocal) {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'anu_hospitality_staff');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'u182454130_anuuser');
    define('DB_PASS', 'anu_hospitality_DB1');
    define('DB_NAME', 'u182454130_anu');
}

// SMTP config
define('SMTP_USER', 'info@anuhospitalitystaff.com'); // always use working email
define('SMTP_PASS', 'Anu_Web_01');                  // actual password
define('ADMIN_EMAIL', 'info@anuhospitalitystaff.com'); // admin receives emails
// Set true when testing email locally or on staging server
define('TEST_MODE', true);
?>
