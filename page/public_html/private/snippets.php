<?php

// *** would be better to load them from template files
abstract class Snippets {
    static function head() {
        return '<meta charset="utf-8">' .
            '<meta name="viewport" content="width=device-width, initial-scale=1">' .
            '<title>KódKihívás</title>' .
            '<link rel="icon" href="favicon.ico">' .
            '<link rel="stylesheet" ' .
                'href="/dist/node_modules/bootstrap/dist/css/bootstrap.min.css">' .
            '<link href="/css/common.css" rel="stylesheet">';
    }

    // $page can be 'challenge' or 'results'
    static function navbar($page) {
        // *** could it be done so that the page doesn't scroll under the navbar, so scrolling to elements is easier?
        $result = '<nav class="navbar navbar-expand-sm sticky-top mb-2"><div class="container ' .
                'justify-content-start">' .
            '<a class="navbar-brand pt-0 pb-0 fs-3" href="/">' .
                '<img src="/img/icon.png" id="icon" alt="KódKihívás" class="me-2">' .
                'KódKihívás' .
            '</a>' .
            '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-collapsible" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">' .
                '<span class="navbar-toggler-icon"></span>' .
            '</button>' .
            '<div id="navbar-collapsible" class="collapse navbar-collapse mt-1 mt-sm-0">' .
                '<span id="nav-choose-challenge-lab" class="navbar-text">Válassz egy kihívást:</span>' .
                '<ul class="navbar-nav navbar-nav-scroll">' .
                    '<li class="nav-item dropdown">' .
                        '<a id="nav-current-challenge" class="nav-link dropdown-toggle';
        if ( $page === 'challenge' )
            $result .= ' active';
        $result .= '" role="button" data-bs-toggle="dropdown" aria-expanded="false"';
        if ( $page === 'challenge' ) {
            $activeChallengeName = basename($_SERVER['SCRIPT_NAME'], '.php');
            $result .= ' data-challenge-name="' . htmlspecialchars($activeChallengeName) . '"';
        }
        $result .= '></a>' .
                        '<ul id="nav-challenges" class="dropdown-menu"></ul>' .
                    '</li>' .
                    '<li class="nav-item">' .
                        '<a class="nav-link';
        if ( $page === 'results' )
            $result .= ' active';
        $result .= '" href="/eredmenyek">Eredmények</a>' .
                    '</li>' .
                '</ul>' .
            '</div>' .
            '</div></nav>';
        return $result;
    }

    // requires /js/challengepage.js to be included
    static function solutionForm($challengeName, $exerciseNo) {
        $id = $challengeName . '-' . $exerciseNo;
        return '<div class="row mb-3">' .
            '<form action="/api/solutions.php" method="post" class="solution-form">' .
                '<div class="col-lg-7"><div class="border rounded-3 p-2 bg-primary-subtle">' .
                    '<input type="hidden" name="action" value="add">' .
                    '<input type="hidden" name="challengeName" value="' . $challengeName . '">' .
                    '<input type="hidden" name="exerciseNo" value="' . $exerciseNo . '">' .
                    '<legend>Megoldás beküldése: <b>' . $exerciseNo . '.</b> feladathoz</legend>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-player" class="form-label">Név</label>' .
                        '<select id="sol-' . $id . '-player" class="form-select player-select" name="playerId" required></select>' .
                    '</div>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-password" class="form-label">Jelszó</label>' .
                        '<input type="password" id="sol-' . $id . '-password" class="form-control" name="password" required>' .
                    '</div>' .
                    '<div class="mb-3">' .
                        '<label for="sol-' . $id . '-code" class="form-label">Másold ide a kódodat (solution függvényt)</label>' .
                        '<textarea id="sol-' . $id . '-code" class="form-control" name="code" rows="3" required></textarea>' .
                    '</div>' .
                    '<button type="submit" class="btn btn-primary">Küldés</button>' .
                '</div></div>' .
                '<div class="w-100"></div>' .
                '<div class="solution-alert col-lg-7 mt-2 d-none"></div>' .
            '</form>' .
        '</div>';
    }

    static function foot() {
        return '<script src="/dist/node_modules/jquery/dist/jquery.min.js"></script>' .
            '<script src="/dist/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js">' .
                '</script>' .
            '<script src="/js/common.js"></script>';
    }
}

?>
