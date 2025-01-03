<?php

// *** would be better to load them from template files
abstract class Snippets {
    static function head() {
        return '<meta charset="utf-8">' .
            '<meta name="viewport" content="width=device-width, initial-scale=1">' .
            '<title>KódKihívás</title>' .
            '<link rel="icon" href="favicon.ico">' .
            '<link rel="stylesheet" ' .
                'href="/dist/public/node_modules/bootstrap/dist/css/bootstrap.min.css">' .
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

    // requires /js/challengepage.js to be included
    static function solutionForm($challengeId, $excerciseNo) {
        $id = $challengeId . '-' . $excerciseNo;
        return '<div class="row mb-3">' .
            '<form class="solution-form">' .
                '<div class="col-lg-7"><div class="border rounded-3 p-2 bg-primary-subtle">' .
                    '<input type="hidden" name="challengeId" value="' . $challengeId . '">' .
                    '<input type="hidden" name="excerciseNo" value="' . $excerciseNo . '">' .
                    '<legend>Megoldás beküldése: <b>' . $excerciseNo . '.</b> feladathoz</legend>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-player" class="form-label">Név</label>' .
                        '<select id="sol-' . $id . '-player" class="form-select player-select" name="player" required></select>' .
                    '</div>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-password" class="form-label">Jelszó</label>' .
                        '<input type="password" id="sol-' . $id . '-password" class="form-control" name="password" required>' .
                    '</div>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-code" class="form-label">Másold ide a kódodat (solution függvényt)</label>' .
                        '<textarea id="sol-' . $id . '-code" class="form-control" rows="3" required></textarea>' .
                    '</div>' .
                    '<button type="submit" class="btn btn-primary">Küldés</button>' .
                '</div></div>' .
                '<div class="w-100"></div>' .
                '<div class="solution-alert col-lg-7 mt-2 d-none"></div>' .
            '</form>' .
        '</div>';
    }

    static function foot() {
        return '<script src="/dist/public/node_modules/jquery/dist/jquery.min.js"></script>' .
            '<script src="/dist/public/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js">' .
                '</script>' .
            '<script src="/js/common.js"></script>';
    }
}

?>
