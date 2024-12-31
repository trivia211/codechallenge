<?php

function dbh() {
    static $dbh = null;
    if ( $dbh === null ) {
        $options = array(
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            // this also ensures PDO returns values with correct data types
            PDO::ATTR_EMULATE_PREPARES=>false,
            PDO::MYSQL_ATTR_FOUND_ROWS=>true
        );
        $dbh = new PDO("mysql:host=" . Config::MYSQL_HOST_ . ";dbname=" . Config::DB_NAME .
            ";charset=utf8mb4", Config::MYSQL_USER, Config::MYSQL_PASSWORD, $options);
    }
    return $dbh;
}

?>