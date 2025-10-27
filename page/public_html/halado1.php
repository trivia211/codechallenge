<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/snippets.php";

checkAuth();
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
            <source src="/media/halado1-ypURuMfNfQipzpL9lt9D.mp4" type="video/mp4">
            A böngésződ nem tudja lejátszani ezt a videót.
        </video>
        <ul>
            <li><a href="/assets/p5play-project.7z">Q5.js és P5play kiindulási projekt</a></li>
            <li>P5play leírás belépési adatok: user: <code>idhprog01@freemail.hu</code> pw: <code>Progszakkör1#</code></li>
        </ul>
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
        <p>Ha az összes feladat elkészült, a teljes kódot küldd be itt:</p>
        <?php echo Snippets::solutionForm('halado1', 1); ?>
        <h2>Folytatás</h2>
        <video controls class="img-fluid">
            <source src="/media/halado1-2-ypURuMfNfQipzpL9lt9D.mp4" type="video/mp4">
            A böngésződ nem tudja lejátszani ezt a videót.
        </video>
        <p>Kiindulási kód:</p>
        <pre class="bg-primary-subtle">createCanvas()
resizeCanvas(800, 600)

function update() {
}

function draw() {
    background('LightSkyBlue')

    textSize(32)
    fill('black')
    text("Mi a titkom?", 100, 100)

    fill('yellow')
    circle(400, 300, 150) // Face
    circle(370, 280, 10) // Left eye
    circle(430, 280, 10) // Right eye
    arc(400, 310, 80, 80, 0, 180) // Smile

    fill('Navy')
    square(650, 450, 100)
    fill('Maroon')
    circle(700, 500, 100)

}</pre>
        <p>Feladatok:</p>
        <ol>
            <li>Ha lenyomom az egérgombot a &quot;Mi a titkom?&quot; szöveg helyett írjon ki valami nagyon titkosat 😊.</li>
            <li>A mosolygós arc csak akkor jelenjen meg, ha az egér a vászon felső felében van. Ha leviszem, tűnjön el!</li>
            <li>A négyzet és a kör közül csak az egyik jelenjen meg! Amikor nem nyomok meg semmit, a kör, amikor lenyomom az egér <strong>jobb</strong> gombját, a négyzet. Használd ezek közül valamelyiket: <code>mouse.presses(&apos;right&apos;)</code> vagy <code>mouse.pressing(&apos;right&apos;)</code> vagy <code>mouse.released(&apos;right&apos;)</code>.</li>
        </ol>
        <?php echo Snippets::solutionForm('halado1', 2); ?>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/challengepage.js"></script>
</body>
</html>
