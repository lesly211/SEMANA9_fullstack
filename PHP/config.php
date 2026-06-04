<?php
define('APP_NAME', 'Lab09 - Semana 9');
define('APP_VERSION', '1.0');
define('CHARSET', 'UTF-8');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lab09');
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure'   => false,
        'use_strict_mode' => true,
    ]);
}

function esc(string $valor): string {
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, CHARSET);
}
?>
