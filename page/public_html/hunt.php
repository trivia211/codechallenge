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
    <link href="/css/hunt.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>4. Vadászat</h1>
        <div id="alert" class="d-none mb-3"></div>
        <p>Itt a vadászszezon! A feladatot <a href="https://aijs.io/editor?user=trivia21&project=Hunt" target="_blank">INNEN</a> tudod megnyitni. (Nyisd meg a challenge.js-t, majd a solution.js-t, és zárd be az index.html-t. A solution.js-be írd a megoldást!) Két fontos utasításod van:</p>
        <p><code>setPlace(szám, kép)</code>: a <code>szám</code> sorszámú mezőre berakja a <code>kép</code>-et. A szám 0-47 lehet, a kép pedig <code>"tree"</code>, <code>"rabbit"</code>, <code>"pirate"</code>, <code>"hunter"</code>, <code>"diamond"</code>. Vagy <code>null</code> idézőjelek nélkül, a mező kiürítéséhez.</p>
        <p><code>await sleep(ezredmásodperc)</code>: várakozik a program. Pl. <code>await sleep(1000)</code> 1 másodpercet.</p>
        <p><span class="badge text-bg-info">Példakód</span> Így lehet telerajzolni a térképet fákkal:</p>
<pre>for ( let i = 0; i &lt; 48; i = i + 1 )
{
    setPlace(i, "tree")
}</pre>
        <p><b class="fs-5">1. </b>Írj egy programot, ahol az erdő közepén (a 28-as mezőn) egy nyuszi ül!</p>
        <img src="/img/hunt/exc-1.png" class="img-fluid mb-4 exc-img">
        <?php echo Snippets::solutionForm('hunt', 1); ?>
        <p><span class="badge text-bg-info">Példakód</span> Így lehet felváltva kalózt és gyémántot rajzolni. Az <code>i</code> változót kettesével léptetjük.</p>
<pre>for ( let i = 0; i &lt; 48; i = i + 2 )
{
    setPlace(i, "pirate")
    setPlace(i + 1, "diamond")
}</pre>
        <p><span class="badge text-bg-info">Példakód</span> Vigyázat! A fenti módszernél végig kell gondolni, hogy <code>i + 1</code> mindig a pályán van-e! Pl. ha a pálya 0-6-ig tartana, <code>i</code> = 6 esetén a gyémántot az <code>i + 1</code> = 7 helyre próbálná rajzolni, ami <code>Érvénytelen place id: 7</code> hibaüzenethez vezetne. Erre egy megoldás, ha külön rajzoljuk ki a kalózokat és a gyémántokat:</p>
<pre>for ( let i = 0; i &lt; 7; i = i + 2 )
{
    setPlace(i, "pirate")
}
for ( let i = 1; i &lt; 7; i = i + 2 )
{
    setPlace(i, "diamond")
}</pre>
        <p><b class="fs-5">2. </b>Írj egy programot, ahol az erdő szélén (0. mező) egy vadász van, utána felváltva fák és nyuszik!</p>
        <img src="/img/hunt/exc-2.png" class="img-fluid mb-4 exc-img">
        <?php echo Snippets::solutionForm('hunt', 2); ?>
        <p><span class="badge text-bg-info">Példakód</span> Nyuszi eltüntetése és megjelenítése ritmusosan:</p>
<pre>setPlace(0, "rabbit")
await sleep(700)
setPlace(0, null)
await sleep(700)
setPlace(0, "rabbit")
await sleep(700)
setPlace(0, null)
await sleep(700)</pre>
        <p><b class="fs-5">3. </b>Írj egy programot, ahol a nyuszi végigszalad az összes mezőn. A háttér lehet üres, vagy lehetnek fák is.</p>
        <img src="/img/hunt/exc-3.gif" class="img-fluid mb-4 exc-img">
        <?php echo Snippets::solutionForm('hunt', 3); ?>
        <p><em>Választható feladat koronáért</em>: ha van kedved a kihíváshoz, készíts programot, ahol az egyik irányból a vadász szalad, másik irányból a nyuszi. Középen találkoznak, de elszaladnak egymás mellett. Lehet üres is a háttér. Tipp: egy egyszerű matematikai művelet kell a visszafelé szaladó szereplőhöz!</p>
        <img src="/img/hunt/exc-4.gif" class="img-fluid mb-5 exc-img">
        <?php echo Snippets::solutionForm('hunt', 4); ?>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/challengepage.js"></script>
</body>
</html>
