<?php

abstract class Snippets {
    static function head() {
        return '<meta charset="utf-8">' .
            '<meta name="viewport" content="width=device-width, initial-scale=1">' .
            '<title>KódKihívás</title>' .
            '<link rel="icon" href="favicon.ico">' .
            '<link href="/dist/public/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">';
    }

    static function foot() {
        return '<script src="/dist/public/node_modules/jquery/dist/jquery.min.js"></script>' .
            '<script src="/dist/public/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>';
    }
}

?>
