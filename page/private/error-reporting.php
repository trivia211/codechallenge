<?php

// $type can be 'DEV' or 'PROD'
function set_error_reporting($type) {
    if ( $type === 'DEV' ) {
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        ini_set('display_startup_errors', 'On');
        ini_set('log_errors', 'Off');
    }
    elseif ( $type === 'PROD' ) {
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
        ini_set('display_errors', 'Off');
        ini_set('display_startup_errors', 'Off');
        ini_set('log_errors', 'On'); // /var/log/apache2/error.log by default
    }
}

?>
