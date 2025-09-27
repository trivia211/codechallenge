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
    <link href="/css/p5intro.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>P5Play Intro</h1>
        <p>A kódszerkesztőt <a href="https://aijs.io/editor?user=trivia21&project=p5play" target="_blank">EZEN A LINKEN</a> tudjátok megnyitni.</p>
        <ol id="tasks">
            <li>
                <strong>Canvas létrehozása:</strong> A kódszerkesztőben hozz létre egy vásznat.
                <pre>function setup() {
    createCanvas()
    resizeCanvas(800, 600)
}</pre>
            </li>
            <li>
                <strong>Új Sprite létrehozása, szintén a <code>setup</code> függvényben:</strong>
                <pre>new Sprite()</pre>
            </li>
            <li>
                <strong>Sprite tulajdonságainak beállítása</strong>: Nézd meg, miket lehet bállítani <a href="https://p5play.org/learn/sprite.html" target="_blank">ezen a linken</a>. A sprite-ot le kell menteni egy változóba:
                <pre>let s = new Sprite()</pre>
            </li>
            <li>
                <strong>Háttér színének megváltoztatása:</strong> Használd a <code>background()</code> függvényt a <code>setup()</code>-ban.
                <pre>background("blue")</pre>vagy
                <pre>background(150, 230, 13)</pre>
            </li>
            <li>
                <strong>Több sprite:</strong> Hozz létre több sprite-ot, csak ne takarják el egymást.
            </li>
            <li>
                <strong>Véletlen koordinátájú Sprite-ok:</strong> mindegyik sprite <code>x</code> és <code>y</code> koordinátáját véletlenszerűen állítsd be. Ehhez használd a <code>random()</code> függvényt a megfelelő számokkal:
                <pre>random(0, 800)</pre>
            </li>
            <li>
                <strong>Sok Sprite:</strong> emlékszel a <code>for</code> ciklusra? Hozz létre 50 sprite-ot véletlenszerű koordinátákkal!
                <pre>for ( let i = 0; i < 50; i = i + 1 ) {
}</pre>
            </li>
            <li>
                <strong>Sprite mozgatása:</strong> <a href="https://p5play.org/learn/sprite.html?page=3" target="_blank">Ezen a linken</a> láthatod, hogyan mozgatható a sprite. Bejelentkezés: user: <code>idhprog01@freemail.hu</code> pw: <code>Progszakkör1#</code><br>
                Újra legyen 1 db spriteunk! Beállítható a <code>velocity</code>, vagy rövidebben <code>vel</code> tulajdonsága. A <code>velocity</code> egy objektum, aminek <code>x</code> és <code>y</code> tulajdonságai vannak.
                <pre>s.vel.x = 2</pre>
            </li>
            <li><strong>Mozgó sprite nyomvonalának eltüntetése</strong> Lehet, hogy rossz helyen van a <code>background</code> utasítás?</li>
            <li><strong>Egyéb irányok?</strong> Tudod átlósan, mindenféle irányban mozgatni a sprite-ot?</li>
            <li>
                <strong>Sprite mozgatása egérhez:</strong> a <code>draw</code> fügvény minden frame megrajzolása előtt lefut. Ide rakjuk be, hogy a sprite ugorjon az egérhez. Az <code>x</code> koordinátára a megoldás:
                <pre>function draw() {
    s.x = mouse.x
    // y-ra is csináld meg!
}</pre>
            </li>
            <li>
                <strong>Sprite lökdösése: </strong> Hozz létre egy második sprite-ot, és próbáld lökdösni az elsővel.
            </li>
            <li>
                <strong>moveTowards: </strong> Elég bénán lökdösi. Ennek az az oka, hogy az első sprite nem mozog, hanem ugrál, mindig odaugrik az egérmutatóhoz. A <code>moveTowards()</code> függvénnyel ugrás helyett az egérmutató <em>felé</em> mozgathatod:
                <pre>s.moveTowards(mouse)</pre>
                Ha azt szeretnéd, hogy jobban kövesse az egeret, állts be egy 0 és 1 közötti számot a gyorsaságnak:
                <pre>s.moveTowards(mouse, 0.8)</pre>
            </li>
            <li>
                <strong>Sok sprite lökdösése 😊: </strong> For ciklussal hozz létre sok lökdöshető sprite-ot véletlen koorindátákkal!
            </li>
            <li>
                <strong>Gravitáció bekapcsolása:</strong> Kapcsold be a gravitációt. Megtalálod, hogyan kell, <a href="https://p5play.org/learn/sprite.html?page=1" target="_blank">ezen a linken</a>?
            </li>
            <li>
                <strong>Padló létrehozása:</strong> Készítsünk egy padlót, ami megfogja a leeső sprite-okat! Hozz létre egy padló spriteot alulra, ami végigér a képernyőn és kb. 10 pixel vastag! Amíg létrehozod, kapcsold ki a gravitációt! Figyelj arra, hogy a koordináták a padló <em>középpontját</em> jelölik!
            </li>
            <li>
                <strong>Nem túl stabil padló:</strong> Most kapcsold vissza a gravitációt! Mi történik? Hogyan fixálhatjuk a padlót? Az ütközőjét (collider) static-ra kell állítani. Ez azt jelenti, hogy a gravitáció és a többi sprite nem hat rá. Kétféleképpen is beállíthatod:
                <pre>floor.collider = STATIC
// vagy:
floor.static = true</pre>
            </li>
            <li>
                <strong>Mozgatás billentyűzetről:</strong> <a href="https://p5play.org/learn/input.html?page=1" target="_blank">Itt</a> meg tudod nézni, hogyan lehet érzékelni, ha megnyomtak egy billentyűt. A játék irányítását az <code>update</code> függvénybe kell írni. A szavak jelentése: <code>kb</code> = keyboard, <code>pressing</code> = lenyomva.
                <pre>function update() {
    if ( kb.pressing("left") )
        fonok.color = "pink"
}</pre>
                <p>Hogyan lehetne megcsinálni, hogy jobb gombnál pedig piros színűvé váljon? Nézd meg a <a href="tudastar" target="_blank">Tudástárban</a> az <code>if</code> utasítást!</p>
                <p>Hogyan lehetne megcsinálni, hogy mozogjon jobbra / balra? Próbáld meg a sebességének a beállításával. Keresd meg ezen az oldalon feljebb, hogyan kell!</p>
                <p>Mozgasd fel és lefelé is!</p>
            </li>
        </ol>
    <p>Folytatás: <a href="/cannon">Ágyús játék</a>.</p>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
