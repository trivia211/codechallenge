<?php

// *** would be better to load them from template files
abstract class Snippets {
    static function head() {
        return '<meta charset="utf-8">' .
            '<meta name="viewport" content="width=device-width, initial-scale=1">' .
            '<title>KódKihívás</title>' .
            '<link rel="icon" href="favicon.ico">' .
            '<link href="/dist/public/node_modules/bootstrap/dist/css/bootstrap.min.css" ' .
                'rel="stylesheet">' .
            '<link href="/css/common.css" rel="stylesheet">';
    }

    static function navbar($active) {
        // *** could it be done so that the page dosen't scroll under the navbar, so scrolling to elements is easier?
        return '<nav class="navbar navbar-expand-sm sticky-top mb-2"><div class="container ' .
                'justify-content-start">' .
            '<a class="navbar-brand pt-0 pb-0 fs-3" href="/">' .
                '<img src="/img/icon.png" id="icon" alt="KódKihívás" class="me-2">' .
                'KódKihívás' .
            '</a>' .
            '<span class="navbar-text">Válassz egy kihívást:</span>' .
            '<ul class="navbar-nav navbar-nav-scroll">' .
                '<li class="nav-item dropdown">' .
                    '<a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" ' .
                        'aria-expanded="false">' . htmlspecialchars($active) . '</a>' .
                    '<ul class="dropdown-menu">' .
                        '<li><a class="dropdown-item" href="/rudolf.php">1. Rudolf</a></li>' .
                    '</ul>' .
                '</li>' .
            '</ul>' .
            '</div></nav>';
    }

    static function foot() {
        return '<script src="/dist/public/node_modules/jquery/dist/jquery.min.js"></script>' .
            '<script src="/dist/public/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js">' .
                '</script>' .
            '<script src="/js/common.js"></script>';
    }
}

?>
