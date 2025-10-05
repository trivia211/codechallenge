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
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Sanyi I.</h1>
        <p>Szia Sanyi! Elkészült az első egyéni programozós videó csak neked!</p>
        <video controls class="img-fluid">
            <source src="/media/sanyi1.mp4" type="video/mp4">
            A böngésződ nem tudja lejátszani ezt a videót.
        </video>
        Linkek:
        <ul>
            <li><a href="assets/p5play-project.7z">P5Play projekt</a></li>
            <li><a href="https://p5play.org/learn/">P5Play leírás</a></li>
        </ul>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
