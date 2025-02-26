<?php
if ( !defined('ROOT') )
    define('ROOT', __DIR__ . "/..");
mb_internal_encoding("UTF-8");
require_once ROOT . "/local/config.php";
require_once ROOT . "/private/error-reporting.php";
setErrorReporting(Config::ERROR_REPORTING);
require_once ROOT . "/private/csrf.php";

?>
