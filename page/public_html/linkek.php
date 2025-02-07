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
            <li><a href="https://prog.vikweb.hu/rudolf">1. Rudolf</a><br>
                Ha még nem csináltad meg, érdemes ezzel kezdeni!
                <ul>
                    <li><a href="https://drive.google.com/file/d/1jFEaJdFGF4JL71LRFyzrEiJ8fpa7beJv/view?usp=drive_link">1.-3. feladat VIDEÓ</a></li>
                </ul>
            </li>
            <li><a href="https://prog.vikweb.hu/squidgame">2. Tintahaljáték</a>
                <ul>
                    <li><a href="https://drive.google.com/file/d/1L2dkipPymiINsot30e4S_BAD3jAabjyU/view?usp=drive_link">1.-2. feladat VIDEÓ</a></li>
                    <li><a href="https://drive.google.com/file/d/1TlVHxNEayq9Kd5755QLsM2zNdYpODt_U/view?usp=sharing">3. feladat VIDEÓ</a> Érdemes megnézni, megmutatom az új kódszerkesztőt!</li>
                </ul>
            </li>
        </ul>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/knowledgebase.js"></script>
</body>
</html>
