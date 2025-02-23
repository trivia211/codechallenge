<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/snippets.php";
?>
<!doctype html>
<html lang="hu">
<head>
    <?php echo Snippets::head(); ?>
</head>
<body>
    <?php echo Snippets::navbar('linkek'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Linkek</h1>
        <ul class="fs-5">
            <li><a href="/rudolf">1. Rudolf</a><br>
                Ha még nem csináltad meg, érdemes ezzel kezdeni!
                <ul>
                    <li><a href="https://drive.google.com/file/d/1jFEaJdFGF4JL71LRFyzrEiJ8fpa7beJv/view?usp=drive_link" target="_blank">1.-3. feladat VIDEÓ</a></li>
                </ul>
            </li>
            <li><a href="/squidgame">2. Tintahaljáték</a>
                <ul>
                    <li><a href="https://drive.google.com/file/d/1L2dkipPymiINsot30e4S_BAD3jAabjyU/view?usp=drive_link" target="_blank">1.-2. feladat VIDEÓ</a></li>
                    <li><a href="https://drive.google.com/file/d/1TlVHxNEayq9Kd5755QLsM2zNdYpODt_U/view?usp=sharing" target="_blank">3. feladat VIDEÓ</a> Érdemes megnézni, megmutatom az új kódszerkesztőt!</li>
                </ul>
            </li>
            <li><a href="/brown">3. Brown mozgás</a><br>
                Ez egy könnyebb feladat, az is megpróbálhatja, aki le van maradva.
                <ul>
                    <li><a href="https://drive.google.com/file/d/1v1Iq8ZfW5uT6Q8XJpSWcdJeJRxxd848v/view?usp=sharing" target="_blank">VIDEÓ</a></li>
                </ul>
            </li>
            <li><a href="https://aijs.io/editor?user=trivia21&project=Hunt" target="_blank">Gyakorlás: Vadászat</a></li>
        </ul>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/knowledgebase.js"></script>
</body>
</html>
