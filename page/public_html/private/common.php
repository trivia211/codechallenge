<?php

// PHP date_create_from_format can parse invalid dates. this rejects them too returning false.
function myDateCreateFromFormat(string $format, string $time, DateTimeZone $timezone = null) {
    if ( $timezone === null )
        $result = date_create_from_format($format, $time);
    else
        $result = date_create_from_format($format, $time, $timezone);
    if ( $result !== false && date_get_last_errors()['warning_count'] > 0 )
        $result = false;
    return $result;
}

?>
