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
    <link href="/css/rudolf.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>1. Rudolf</h1>
        <div id="alert" class="d-none mb-3"></div>
        <img src="/img/rudolf/1.jpg" class="float-end ms-3 mb-3 storyimg-28em">
        <p>Üdv a KódKihívás oldalán! Ez lesz az első kihívás, amivel szembe kell nézz!</p>
        <p>Karácsonyi díszbe öltözött a világ. A gyerekek izgatottan várják a Mikulás érkezését. Van azonban egy ország, melynek őrült uralkodója aknamezőkkel akarja távol tartani őt! Szerencsére a Mikulás repülve érkezik, így egyáltalán nem érdeklik a földön elrejtett robbanóanyagok. Az örök kétbalkezes rénszarvas, Rudolf azonban óriási hibát követ el: megbotlik egy aprócska repülő drónban. A szán megpördül, és csak a szerencsén múlik, hogy a Mikulás nem zuhan alá. Sajnos az ajándékok fele így is kiborul, és hosszú zuhanás után szétszóródik földön.</p>
        <p>A Mikulás éktelen haragra gerjed. Rudolfot az országban hagyja, megparancsolja neki, hogy ezeket az ajándékokat egyedül szedje össze, és ossza szét a gyerekek között. Addig vissza ne térjen az Északi-sarkra, amíg nem végez!</p>
        <p>Rudolf munkához is lát. A földön elrejtett bombák miatt nem mer leereszkedni a földre. Szerencsére van egy ügyes kis robotja, amit le tud küldeni a földre. A robotot azonban be kell programozni, hogy csak az ajándékokat hozza vissza, és nehogy hozzányúljon a bombákhoz! Rudolf a <span id="you">Te</span> segítségedet kéri ehhez! (Ez nem furcsa, már évek óta haverok vagytok az Instán, meg nyáron együtt jártok kajakozni a Hernádra.)</p>
        <p>Hogyan tudsz nekikezdeni a feladatnak? Nyisd meg <a href="https://codeguppy.com/code.html?YLz5OtyGfH4SKPHkESFW" target="_blank">EZEN A LINKEN</a> (vagy az <a href="https://aijs.io/editor?user=trivia21&project=Rudolf" target="_blank">ÚJ KÓDSZERKESZTŐBEN</a>). Ahogy a lenti képen látható, amikor elindítod a programot, 4 <em>slot</em> jelenik meg, 0-tól 3-ig. Mindegyiken vagy egy ajándék, vagy egy bomba van. A program feladata, hogy kiválogassa az ajándékokat a bombák közül!</p>
        <p>Ha most elindítod a programot, a robot egy ajándékot se fog elvenni. A gyorsítógombokkal felgyorsíthatod a program futását. Öszsesen 6 pálya van, és végül 0 pont lesz az eredmény. Hogyan lehetne pontot szerezni?</p>
        <p>Ehhez nézzük meg a kódmezőt a bal oldalon! Keresd meg a solution (=megoldás) nevű függvényt. Ide lehet beírni a megoldást. Pontosabban a két csillagozott sor közé. A képen ki is jelöltem, hova szabad írni. A többi dologhoz ne nyúlj hozzá, mert elromlik a program! 😀</p>
        <p><img src="/img/rudolf/2.jpg" class="img-fluid"></p>
        <p>A solution függvénybe írt kód minden pálya esetén lefut. Próbáljunk ki egy egyszerű utasítást beleírni:</p>
        <pre>println("Helló, fingom sincs, mit kell ide írni!")</pre>
        <p><img src="/img/rudolf/3.jpg" class="img-fluid"></p>
        <p>Futtasd végig a játékot, akár gyorsítva! Na! Itt már történt valami! Hatszor kiírta egymás alá a szöveget. Sajnos a pontszám még mindig 0. Két Rudolfföldi utasasítást tanítok most meg neked, amit felhasználhastsz a megoldáshoz! Az egyik a <code>slot(X)</code>, ahol X a slot száma (0, 1, 2 vagy 3). Ez a függvény megmondja, mi van a slotban: bomba (B) vagy ajándék (G). Cseréljük le az előző utasítást most erre:</p>
        <pre>function solution()
{
    println(slot(0))
}</pre>
        <p>Ha lefuttatod a játékot, most minden pálya elején kiírja új sorba, hogy a 0. sloton B vagy G van! Ez működik a többi slotra is, nyugodtan próbáld meg! Sőt, mi történik, ha ezt másolod be?</p>
        <pre>function solution()
{
    if ( slot(1) === "B" )
    {
        println("Az 1. helyen bomba van! ÁÁÁ")
    }
    else
    {
        println("Az 1. helyen ajándék van! YESS!")
    }
}</pre>
        <p>Ha az 1. sloton "B"omba va, kiírja, hogy bomba ÁÁÁ, különben, hogy ajándék YESS.</p>
        <p>A második utasítás, amit ismerned kell: <code>take(X)</code>. Ez bizony elveszi azt a dolgot, ami az X. sloton van, akármi is legyen. Próbáld meg, hogy csak ennyit írsz be a solution-be:</p>
        <pre>function solution()
{
    take(1)
}</pre>
        <p>Végre csinál valamit a robot! Mind a hat pályán elveszi, ami az 1. sloton van. Néha ajándék, néha bomba...</p>
        <p><b class="fs-5">1. </b>Az az igazság, hogy most már meg is tudod oldani a feladatot: vedd el az összes ajándékot az összes pályáról! Sose nyúlj bombához! Cél: <b>28</b> pont! Tipp: akár több if utasítást is használhatsz. Nem biztos, hogy az <code>else</code> ágat használni kell, azt ki is hagyhatod! Ha nem sikerül elérni a pontszámot, akkor is mindig töltsd fel a legjobb próbálkozásodat! Ha később találsz jobb megoldást, töltsd fel azt is!</p>
        <?php echo Snippets::solutionForm('rudolf', 1); ?>
        <p>Ha kész vagy, olvass tovább! Megtanulunk egy új utasítást, amivel Rudolf még több pontot tud szerezni Mikinél! Ez a <code>defuse(X)</code> utasítás. Aki tud angolul, tudja, ez azt jelenti: hatástalanít. Bizony, további pontokért a kis robot a bombákat is hatástalanítani tudja! Van azonban egy apróság: mi történik, ha véletlenül nem egy bombát, hanem egy ajándékot szeretnél hatástalanítani? Nyilvánvaló: hát <span class="fw-bold text-danger">FELROBBAN</span>! Próbáld is ki ezzel az egyszerű utasítással:</p>
        <pre>function solution()
{
    take(1)
    defuse(2)
}</pre>
        <p><b class="fs-5">2. </b>Középhaladó feladat: szerzd meg az összes ajándékot és hatástalanítsd az összes bombát! Cél: <b>38</b> pont!</p>
        <?php echo Snippets::solutionForm('rudolf', 2); ?>
        <p>Ki gondolta volna, van egy utolsó, varázslatos utasítás: <code>conjure(X)</code>, ami azt jelenti: elvarázsol! Nem is mondom meg, mit csinál. Próbáld ki magad! Figyeld, mi hány pontot ad!</p>
        <p><b class="fs-5">3. </b>Profi feladat: most, hogy mind a 4 utasítást/függvényt ismered, írj programot, ami a lehető legtöbb pontot szerzi! Hogy hogyan? Mit tudom én! Cél: az ultra kemény<b class="fs-1"> 48 </b>pont! Hajrá!</p>
        <?php echo Snippets::solutionForm('rudolf', 3); ?>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/challengepage.js"></script>
</body>
</html>
