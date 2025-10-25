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
        <h1>Haladó I.</h1>
        <p>Szia Sanyi és Domi! Elkészült az első haladó otthoni feladat!</p>
        <video controls class="img-fluid">
            <source src="/media/halado1.mp4" type="video/mp4">
            A böngésződ nem tudja lejátszani ezt a videót.
        </video>
        <p>P5play leírás belépési adatok: user: <code>idhprog01@freemail.hu</code> pw: <code>Progszakkör1#</code></p>
        <p>Ebből a kódból tudtok kiindulni:</p>
        <pre class="bg-primary-subtle">createCanvas()
resizeCanvas(800, 600)

function update() {
}

function draw() {
    background('yellow')

    square(125, 133, 100)

    circle(400, 183, 100)

    textSize(25)
    text("mouse.x", 575, 196)

    ellipse(175, 417, 70, 100)

    capsule(358, 375, 442, 459, 8)

    arc(625, 417, 100, 100, 20, -20, PIE);
}</pre>
        <p>Feladatok:</p>
        <ol>
            <li>A négyzet 2 másodperc múlva tűnjön el.</li>
            <li>A kör akkor jelenjen meg, amikor a négyzet eltűnik. (Előtte ne jelenjen meg.)</li>
            <li>A szöveg írja ki az egérkurzor x koordinátáját.</li>
            <li>A tojás csak akkor jelenjen meg, ha az egér a játéktér jobb felén van.</li>
            <li>A kukac színe legyen piros. (Ne romoljon el a szöveg!)</li>
            <li>A kukac színe változzon aszerint, hogy merre mozgatom az egeret. Használjátok az egér x vagy y koordinátáját tetszés szerint.</li>
            <li>A pac-man figura kövesse az egeret.</li>
            <li>Amíg le van nyomva az egérgomb, a pac-man figura legyen nagyobb.</li>
        </ol>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
