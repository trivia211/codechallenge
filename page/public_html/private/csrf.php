<?php

session_set_cookie_params(['samesite'=>'Strict', 'secure'=>true, 'httponly'=>true]);
session_start();
if ( !isset($_SESSION['csrf_token']) ) {
    $_SESSION['csrf_token'] = rtrim(base64_encode(random_bytes(32)), "=");
    session_write_close();
    $cookie_options = ['expires'=>0, 'samesite'=>'Strict', 'secure'=>true, 'httponly'=>true];
    setcookie('csrf_token', $_SESSION['csrf_token'], $cookie_options);
} else
    session_abort();
if ( isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'GET' &&
        (!isset($_COOKIE['csrf_token']) || $_COOKIE['csrf_token'] !== $_SESSION['csrf_token']) ) {
    http_response_code(403);
    exit("Invalid CSRF token.");
}

?>