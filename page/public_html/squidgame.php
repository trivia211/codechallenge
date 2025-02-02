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
    <link href="/css/squidgame.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>2. Tintahaljáték</h1>
        <div id="alert" class="d-none mb-3"></div>
        <img src="/img/squidgame/level.jpg" class="float-end ms-3 mb-3 storyimg-28em">
        <p>Tintahalfalván Tintahalék Tintahalkátékot játszanak. Te leszel a bíró! A játékosok felállnak a körhintára. Egyszer csak megjelenik egy szám. Mindenkinek be kell szaladni egy szobába. Aki kint marad, kiesik a játékból 🙁! Amelyik szobában nem annyian vannak, mint a szám, ők mind kiesnek.</p>
        <p>Például, a képen a <b>3</b>-as szám van kiírva, minden szobában 3 embernek kell lennie. A két zöld arc, aki nincs bent egyik szobában sem, kiesett. A 0., 1. és 3. szobában 3-an vannak, ezért nem estek ki. A 2. szobában 1 arc van, ő kiesett. Mi a helyzet a piros ruhás alakkal? Ő a bíró, tehát sosem esik ki 😀!</p>
        <div class="alert alert-info overflow-x-hidden" role="alert">
            <h6 class="alert-heading">Pro tipp</h6>
            <p>A fenti sávon találsz egy új linket: <a href="/tudastar" class="alert-link">Tudástár</a>. Itt megtalálsz minden olyan programozási dolgot, amit már tanultunk. Ezeket is felhasználhatod a feladat megoldásához. Ezen az oldalon már csak az új dolgok lesznek megemlítve!</p>
        </div>
        <p>Éés, ha valami nem megy, nyugodtan kérj segítséget 😀!</p>
        <p><b class="fs-5">1. </b>Az első feladatot <a href="https://www.codeguppy.com/code.html?RxVnjIbOqlCxNvXBK8ex">INNEN</a> tudod megnyitni. Ezeket az utasításokat kapod meg:</p>
        <p><code>number()</code>: lekérheted, éppen hanyas szám van középen kiírva. Ne felejtsd el kirakni a zárójeleket az utasítás után!</p>
        <p><code>roomCnt(szobaszám)</code>: lekérheted, éppen hány játékos van egy szobában. (<i>room</i> = szoba, <i>cnt</i> = count = darabszám). FONTOS! A kis- és nagybetűket pontosan kell átmásolnod, különben nem fog működni! Példa: <code>roomCnt(1)</code> a képen 3 lesz, hiszen az 1. számú szobában (jobb oldalt fent) 3 arc van.</p>
        <p><code>killOutside()</code>: eliminálja az összes játékost, akik nincs bent egy szobában. (<i>Outside</i> = odakint.)</p>
        <p><code>killRoom(szobaszám)</code>: eliminálja az összes játékost a <code>szobaszám</code> szobában. Pl. itt a képen a 2. szobában csak egy ember van, így lehet őt kiejteni a játékból: <code>killRoom(2)</code>.</p>
        <p>Itt is 6 pálya van, mint a Rudolfos kihívásban. Például, minden pályán írjuk ki, hányan vannak a 3. szobában. Próbáld végigfuttatni a játékot ezzel a kóddal:</p>
<pre>function solution() {
    print("A 3. szobában ennyi játékos van: ")
    println(roomCnt(3))
}</pre>
        <p>A feladatod tehát a következő: állíts ki mindenkit, aki nincs bent egy szobában, és azokat is, akik nem annyian vannak a szobájukban, ahányas szám szerepel középen. Tipp: használhatod a nem egyenlő (<code>!==</code>) operátort. Nézz utána a Tudástárban! Hajrá!</p>
        <?php echo Snippets::solutionForm('squidgame', 1); ?>
        <p><b class="fs-5">2. </b>Az második feladatot <a href="https://www.codeguppy.com/code.html?dlcEpHHe7gJmIFLjkuFN">INNEN</a> tudod megnyitni. Leszóltak a főnökségtől, hogy túl sokat lövöldözöl odakint, akkor is, amikor egy játékos sem maradt odakint, hanem mindenki bement egy szobába. Szerencsére kaptál egy új utasítást:</p>
        <p><code>outsideCnt()</code>: lekérheted, hány ember van odakint. (Tehát hány ember nem ment be egyik szobába sem.)</p>
        <p>A feladatod ugyanaz, de <b>HA</b> nincs senki odakint, akkor odakint ne lövöldözz, a kinti játékosokat ne állítsd ki! Figyelj rá, hogy a második feladat linkjét nyisd meg!</p>
        <?php echo Snippets::solutionForm('squidgame', 2); ?>
        <p><b class="fs-5">3. </b>Harmadik feladat 3 csillagért: <i>Hamarosan...</i></p>
        <p><b class="fs-5">4. </b>Negyedik feladat koronáért: <i>Hamarosan...</i></p>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/challengepage.js"></script>
</body>
</html>
