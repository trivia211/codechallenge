<?php
if ( !defined('ROOT') )
    define('ROOT', __DIR__ . "/..");
require_once ROOT . "/local/config.php";
require_once ROOT . "/private/error-reporting.php";
set_error_reporting(Config::ERROR_REPORTING);
require_once ROOT . "/private/csrf.php";

?>
