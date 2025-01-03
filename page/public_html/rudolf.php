<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/snippets.php";
?>
<!doctype html>
<html lang="hu">
<head>
    <link href="/css/index.css" rel="stylesheet">
    <?php echo Snippets::head(); ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm sticky-top mb-2"><div class="container justify-content-start">
        <a class="navbar-brand pt-0 pb-0 fs-3" href="/">
            <img src="/img/icon.png" id="icon" alt="KódKihívás">
            KódKihívás
        </a>
        <span class="navbar-text">Válassz egy kihívást:</span>
        <ul class="navbar-nav navbar-nav-scroll">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                1. Rudolf</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/rudolf.php">1. Rudolf</a></li>
                </ul>
            </li>
        </ul>
    </div></nav>
    <div class="container">
        <div class="row"><div class="col">
            <h1>1. Rudolf</h1>
            <img src="/img/rudolf/1.jpg" class="float-end ms-3 mb-3 storyimg-28em">
            <p>Üdv a KódKihívás oldalán! Ez lesz az első kihívás, amivel szembe kell nézz!</p>
            <p>Karácsonyi díszbe öltözött a világ. A gyerekek izgatottan várják a Mikulás érkezését. Van azonban egy ország, melynek őrült uralkodója aknamezőkkel akarja távoltartani őt! Szerencsére a Mikulás repülve érkezik, így egyáltalán nem érdeklik a földön elrejtett robbanóanyagok. Az örök kétbalkezes rénszarvas, Rudolf azonban óriási hibát követ el: megbotlik egy aprócska repülő drónban. A szán megpördül, és csak a szerencsén múlik, hogy a Mikulás nem zuhan alá. Sajnos az ajándékok fele így is kiborul, és hosszú zuhanás után szétszóródik földön.</p>
            <p>A Mikulás éktelen haragra gerjed. Rudolfot az országban hagyja, megparancsolja neki, hogy ezeket az ajándékokat egyedül szedje össze, és ossza szét a gyerekek között. Addig vissza ne térjen az Északi-sarkra, amíg nem végez!</p>
            <p>Rudolf munkához is lát. A földön elrejtett bombák miatt egyedül nem meri összeszedni az ajándékokat. Szerencsére van egy ügyes kis robotja, amit le tud küldeni a földre. A robotot azonban be kell programozni, hogy csak az ajándékokat hozza vissza, és nehogy hozzányúljon a bombákhoz! Rudolf a <span id="you">Te</span> segítségedet kéri ehhez! (Ez nem furcsa, már évek óta haverok vagytok az Instán, meg nyáron együtt jártok kajakozni a Hernádra.)</p>
            <p>Hogyan tudsz nekikezdeni a feladatnak? Nyisd meg <a href="https://www.codeguppy.com/code.html?AthL0hBReLbXJu0paOCN" target="_blank">EZEN A LINKEN</a>. Ahogy a lenti képen látható, amikor elindítod a küldetést, 4 slot jelenik meg, 0-tól 3-ig. Mindegyiken vagy egy ajándék, vagy egy bomba van. A program feladata, hogy kiválogassa az ajándékokat a bombák közül!</p>
            <p>Ha most elindítod a programot, a robot egy ajándékot se fog elvenni. A gyorsítógombokkal felgyorsíthatod a program futását. Öszsesen 6 pálya van, és végül 0 pont lesz az eredmény. Hogyan lehetne pontot szerezni?</p>
            <p>Ehhez nézzük meg a kódmezőt a bal oldalon! Keresd meg a solution (=megoldás) nevű függvényt. Ide lehet beírni a megoldást. Pontosabban a két csillagozott sor közé. A képen ki is jelöltem, hova szabad írni. A többi dologhoz ne nyúlj hozzá, mert elromlik a program! 😀</p>
            <p><img src="/img/rudolf/2.jpg" class="img-fluid"></p>
            <p>A solution függvénybe írt kód minden pálya esetén lefut. Próbáljunk ki egy egyszerű utasítást beleírni:</p>
            <p><pre>println("Helló, fingom sincs, mit kell ide írni!")</pre></p>
            <p><img src="/img/rudolf/3.jpg" class="img-fluid"></p>
            <p>Futtasd végig a játékot, akár gyorsítva! Na! Itt már történt valami! Hatszor kiírta egymás alá a szöveget. Sajnos a pontszám még mindig 0. Két Rudolfföldi utasasítást tanítok most meg neked, amit felhasználhastsz a megoldáshoz! Az egyik a <code>slot(X)</code>, ahol X a slot száma (0, 1, 2 vagy 3). Ez a függvény megmondja, mi van a sloton: bomba (B) vagy ajándék (G). Cseréljük le az előző utasítást most erre:</p>
            <p><pre>function solution() {
    println(slot(0))
}</pre></p>
            <p>Ha lefuttatod a játékot, most minden pálya elején kiírja új sorba, hogy a 0. sloton B vagy G van! Ez működik a többi slotra is, nyugodtan próbáld meg! Sőt, mi történik, ha ezt másolod be?</p>
            <p><pre>function solution() {
    if ( slot(1) === "B" ) {
        println("Az 1. helyen bomba van! ÁÁÁ")
    } else {
        println("Az 1. helyen ajándék van! YESS!")
    }
}
</pre></p>
            <p>Ha az 1. sloton "B"omba va, kiírja, hogy bomba ÁÁÁ, különben, hogy ajándék YESS. A második utasítás, amit ismerned kell: <code>take(X)</code>. Ez bizony elveszi azt a dolgot, ami az X. sloton van, akármi is legyen. Próbáld meg, hogy csak ennyit írsz be a solution-be:</p>
            <p><pre>function solution() {
    take(1)
}</pre></p>
            <p>Végre csinál valamit a robot! Mindig elveszi, ami az 1. sloton van. Néha ajándék, néha bomba...</p>
            <p>Az az igazság, hogy most már meg is tudod oldani a feladatot: vedd el az összes ajándékot az összes pályáról! Sose nyúlj bombához! Cél: <b>28</b> pont! Tipp: akár több if utasítást is használhatsz. Nem biztos, hogy az <code>else</code> ágat használni kell, azt ki is hagyhatod!</p>
        </div></div>
    </div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
