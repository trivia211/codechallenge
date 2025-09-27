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
    <link href="/css/cannon.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Ágyús játék</h1>
        <p>Egy olyan játékot szeretnénk csinálni, ahol van egy kis ágyúnk a képernyő alján, amivel ki kell lőni a leeső bombákat. Az ágyút most nem mozgatni, hanem <em>forgatni</em> lehet, így fogunk vele célozni!</p>
        <p>Ha a p5play leírás bejelentkezést kér, használd ezt: user: <code>idhprog01@freemail.hu</code> pw: <code>Progszakkör1#</code></p>
        <p>A kódszerkesztőt <a href="https://aijs.io/editor?user=trivia21&project=cannon" target="_blank">EZEN A LINKEN</a> tudod megnyitni.</p>
        <ol id="tasks">
            <li>
                <strong>Méret és pozíció:</strong> Túl nagy az ágyú, és rossz helyen is van! Állítsd be a <code>scale</code> (átméretezés) tulajdonságát! Akár törtszámot is használhatsz, pl. <pre>valami.scale = 1.5</pre>Keress neki egy jó méretet, és rakd a képernyő aljára!
                <div class="row justify-content-center"><div class="col-xl-6 col-lg-7 col-md-10"><img src="/img/others/cannon1.jpg" class="img-fluid mb-3 border"></div></div>
            </li>
            <li>
                <strong>Forgatás:</strong> Nyomd le a jobb nyílbillentyűt &rarr;! Fordul az ágyú? A <a href="https://p5play.org/learn/sprite.html?page=7" target="_blank">rotationSpeed</a> beállításával lehet forgatni. A korábban tanultak alapján csináld meg, hogy mindkét irányba lehessen forgatni!
            </li>
            <li>
                <strong>Lövedék megjelenítése:</strong> Amikor a <code>space</code> billentyűt lenyomják, jelenjen meg egy lövedék az ágyú csövénél! Az <code>update</code> függvénybe (a forgatás alá) kell beírni a kódot. Ez fog kelleni hozzá:
                <pre>if ( kb.pressing("space") ) {
    let golyo = new Sprite()
}</pre>
                Be tudod fejezni a kódot, hogy a megfelelő helyen egy jó színű golyó (kör) jelenjen meg?
            </li>
            <li>
                <strong>Túl sok golyó:</strong> Sajnos rengeteg golyó megjelenik akkor is, ha rögtön felengedjük a space-t. Csináljuk meg, hogy minden lenyomásnál csak egy jelenjen meg! Próbáld ki ezeket, nézd meg, mit csinálnak:
                <ul>
                    <li>
                        Épp ebben a pillanatban nyomták le a space-t?
                        <pre>kb.presses("space")</pre>
                    </li>
                    <li>
                        Le van nyomva a space?
                        <pre>kb.pressing("space")</pre>
                    </li>
                    <li>
                        Épp ebben a pillanatban <em>engedték fel</em> a space-t?
                        <pre>kb.released("space")</pre>
                    </li>
                </ul>
            </li>
            <li>
                <strong>Ágyú rühelli lövedéket:</strong> Sajnos az ágyú és a lövedék taszítja egymást, nem tudnak egy helyen megmaradni. Ezt úgy oldjuk meg, hogy beállítjuk a <code>physics</code> tulajdonságát egy barátságosabb értékre. Találd ki, az alábbiak közül melyiket kell választanod az ágyúhoz és a golyóhoz:<br>
                <ul>
                    <li>
                        Ellöki a többi sprite-ot és őt is el lehet lökni:
                        <pre>valami.physics = DYNAMIC</pre>
                    </li>
                    <li>
                        Mozdulatlan, a többi sprite beleütközik:
                        <pre>valami.physics = STATIC</pre>
                    </li>
                    <li>
                        Mozoghat, ellöki a többi sprite-ot (kivéve a KINEMATIC-okat), de őt nem lehet ellökni:
                        <pre>valami.physics = KINEMATIC</pre>
                    </li>
                    <li>
                        Nem lök el senkit, keresztülmegy a többi sprite-on:
                        <pre>valami.physics = NONE</pre>
                    </li>
                </ul>
            </li>
            <li>
                <strong>Lövedék sebessége:</strong> Eddig a sprite-okat a <code>.vel.x</code> és <code>.vel.y</code> beállításával mozgattuk. <a href="https://p5play.org/learn/sprite.html?page=3" target="_blank">ITT</a> találsz egy másik módszert: <code>.speed</code> és <code>.direction</code>. Külön állítható a sebesség és az irány. Először állítsd be a golyó sebességét 10-re!
            </li>
            <li>
                <strong>Direction:</strong> Na jó, de rossz irányba megy a golyó! Próbáld ki, hogy mindenféle értékeket beállítasz a <code>.direction</code> tulajdonságnak, pl 10, 90, 180, -90! Rájössz, hogy működik?
            </li>
            <li>
                <strong>Rotation:</strong> De jó lenne, ha arra tudnánk lőni, amerre éppen fordul az ágyú! Használd az ágyú <code>.rotation</code> tulajdonságát, az irány beállításához!<pre>lovedek.direction = agyu.rotation</pre>
            </li>
            <li>
                <strong>Lövedék iránya:</strong> Ha figyeltél matekórán, és emlékszel a szögekre, akkor egyedül ki tudod javítani a programot, hogy a jó irányba lője ki az ágyút. Hajrá!
            </li>
            <li>
                <strong>Időzítés:</strong> A lehulló bombák két másodpercenként fognak megjelenni a képernyő tetején. Hogyan lehet megcsinálni, hogy valami szabályos időközönként ismétlődjön? Egy lehetőség: az <code>update</code> függvénybe (a többi kód alá) írd be:
                <pre>if ( frameCount % 120 === 0 ) {
    new Sprite()
}</pre>
                Mi az a <code>frameCount</code>? Megmondja, hány frame (képkocka) óta fut a játék. A <code>%</code> a maradékos osztás, tehát minden 120-adik képkockánál jön létre az új Sprite. Miért pont 120? Mert a játék 60 FPS-el fut, tehát két másodperc az már 120 frame.
            </li>
            <li>
                <strong>Bombák:</strong> Csináld meg, hogy az új sprite-ok (bombák) a képernyő tetején jelenjenek meg véletlenszerű helyen! Emlékeztető: <code>random(0, 800)</code> (feltéve, hogy 800 széles a canvas).
            </li>
            <li>
                <strong>Zuhanó bombák:</strong> Most pedig csináld meg, hogy a bombák egyenletes sebességgel lefelé zuhanjanak! Ne a gravitációt kapcsold be, mert akkor gyorsulva zuhannának. Inkább állítsd be a sebességüket. Melyiket könnyebb itt használni? <code>.vel.x</code>, <code>.vel.y</code>? Vagy <code>.speed</code>, <code>.direction</code>?
            </li>
        </ol>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
