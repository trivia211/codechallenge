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
    <link href="/css/brown.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col main-container">
        <h1>3. <span class="brown">Brown</span> mozgás <small class="text-body-secondary">- majd, ha piros hó esik felfelé!</small></h1>
        <div id="alert" class="d-none mb-3"></div>
        <p>Ez a feladat kicsit más, mint az előzők. Különféle tárgyakat fogunk mozgatni a képernyőn, a végén akár a hó is eleredhet! Vágjunk is bele!</p>
        <p>A feladat <a href="https://aijs.io/editor?user=trivia21&project=Brown-1" target="_blank">INNEN</a> nyitható meg. Hogy jobb javaslatokat adjon a kódszerkesztő, és ne húzza alá a <code>sprite</code> utasítást, a következőket javaslom:</p>
        <ol>
            <li>Zárjátok be az <code>index.html</code>-t.</li>
            <li>Nyissátok meg a <code>challenge.js</code>-t. Ebbe <b>ne</b> írjatok bele.</li>
            <li>Nyissátok meg a <code>solution.js</code>-t, és ebbe írjátok a megoldást.</li>
            <li>Ameddig nem szólok, hogy az <code>update</code> függvénybe kell írni, addig fölé írjátok a kódot (ne bele).</li>
        </ol>
        <p>Egy új játékelem (sprite) létrehozásához használjátok ezt az utasítást:</p>
        <pre>let hopihe = sprite("snow", 400, 300, "orange")</pre>
        <p>Mit is csinál ez? Létrehozunk egy <code>hopihe</code> nevű változót, amibe elmentjük az új sprite-ot. Meghívjuk a <code>sprite</code> utasítást, és vesszővel elválasztva felsoroljuk a paramétereit:</p>
        <ol>
            <li>Milyen kép jelenjen meg. Ezeket lehet beírni, próbáljátok ki: <code>"snow"</code>, <code>"pubg"</code>, <code>"brawl"</code>, <code>"squid"</code>.</li>
            <li><code>x</code> koordinátája a sprite-nak. 0-tól 800-ig.</li>
            <li><code>y</code> koordinátája a sprite-nak. 0-tól 600-ig.</li>
            <li>Milyen színű legyen a sprite. Beírhattok egy <a href="http://www.w3schools.com/TAGS/ref_colornames.asp" target="_blank">színt angolul</a> (idézőjelben), vagy megadhatjátok az RGB komponenseit (0-255) pl. így: <code>[123, 0, 255]</code>.</li>
        </ol>
        <p>Egy kis emlékeztető a koordinátákról!</p>
        <div class="row justify-content-center"><div class="col-xl-6 col-lg-7 col-md-10"><img src="/img/brown/coordinates.png" class="img-fluid mb-3"></div></div>
        <p>Aki szeretné, a háttér színét is beállíthatja. Ugyanolyan színeket lehet bele írni, mint a <code>sprite</code>-ba.</p>
        <pre>background([192, 243, 225])</pre>
        <p>Na, próbáljuk megmozdítani a sprite-ot! Ehhez az <code>update</code> függvénybe kell írnunk, ami másodpercenként 60-szor lefut. (Tehát az FPS 60!) Például növeljük az <code>x</code> koordinátáját a hópihének mindig 1-el! Kitalálod, merre fog elindulni?</p>
<pre>background("Cornsilk")
let hopihe = sprite("snow", 400, 300, "orange")

function update() {
    hopihe.x = hopihe.x + 1
}</pre>
        <p>Akár több sprite-om is lehet, és másfelé is mozgathatom őket, használhatom az <code>y</code> koordinátát is!</p>
<pre>let hopihe = sprite("snow", 400, 300, "orange")
let ho2 = sprite("snow", 400, 100, "blue")

function update() {
    hopihe.x = hopihe.x + 1
    ho2.y = ho2.y + 1
}</pre>
        <p>Az első feladat megoldásához három dologra kell rájönnöd:</p>
        <ol>
            <li>Oké, jobbra és lefele már tud menni a sprite. Hogyan tudna balra vagy felfele? Mit kellene megváltoztatni?</li>
            <li>Oké, most már vízszintesen és függőlegesen tud menni minden irányba. Hogyan tudna ferdén menni?</li>
            <li>Mindig ugyanolyan lassan megy. Mit kéne változtatni, hogy gyorsabban haladjon?</li>
        </ol>
        <p><b class="fs-5">1. </b>Csinálj egy animációt a lenti kép alapján! A nyilak csak azt jelölik, merre kell mozognia a sprite-nak. Nem kell halál pontosan ugyanezt, csak legyen hasonló!</p>
        <div class="row justify-content-center"><div class="col-xl-6 col-lg-7 col-md-10"><img src="/img/brown/exc1.jpg" class="img-fluid mb-3"></div></div>
        <?php echo Snippets::solutionForm('brown', 1); ?>
        <p>Mi lenne, ha a sprite-ok nem egyenes vonalban haladnának, hanem összevissza barangolnának a képernyőn? Ezt hívják Brown mozgásnak. Ehhez kaptunk egy új utasítást, amivel véletlen számokat generálhatunk: <code>random(min, max)</code>. Például, a <code>println(random(10, 20))</code> ki fog írni egy véletlen <b>tört</b>számot 10 és 20 között. Próbáld ki!</p>
        <p>Most pedig csináljuk meg, hogy ne 1-el, hanem véletlen számmal változzon a sprite két koordinátája!</p>
<pre>let ho = sprite("snow", 0, 0, "orange")

function update() {
    ho.x = ho.x + random(0, 2)
    ho.y = ho.y + random(0, 2)
}</pre>
        <p>Látod, hogy már nem egyenletesen megy, hanem izeg-mozog? Viszont sajnos nem összevissza megy, hanem jobbra lefele. Ez mitől lehet? Miért nem megy soha balra és felfele?</p>
        <img class="border float-end mb-3 ms-3" src="/img/brown/exc2.gif" height="150">
        <p><b class="fs-5">2. </b>Csináld meg, hogy a sprite középről induljon, és összevissza mozogjon. Ne menjen el jobbra lefele ilyen gyorsan, sokáig maradjon középen! Ha kész vagy, megcsináltad az igazi Brown mozgást! 😇</p>
        <div class="clearfix"></div>
        <?php echo Snippets::solutionForm('brown', 2); ?>
        <p><b class="fs-5">3. </b>Itt az ideje, hogy <span class="red">piros</span> hó essen felfelé! Csinálj egy animációt amiben 3 vagy több piros hópihe indul alulról (nem ugyanarról a helyről), és fölfelé esnek. De nem csak egyenesen mennek, hanem közben még ide-oda mozognak, Brown mozgást is végeznek, mint az igazi hóesésben!</p>
        <?php echo Snippets::solutionForm('brown', 3); ?>
        <div id="snow-container"></div>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/dist/node_modules/q5/q5.min.js"></script>
    <script src="/js/challengepage.js"></script>
    <script src="/js/brown.js"></script>
</body>
</html>
