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
    <link href="/css/knowledgebase.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('knowledgebase'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Tudástár</h1>
        <div id="alert" class="d-none mb-3"></div>
        <p>Itt megtalálhatsz mindent, amiről már tanultunk, sok példakóddal.</p>
        <h3>if utasítás</h3>
        <p>Ha a <code>slot(1)</code> értéke pont a <code>"B"</code> szöveg, kiírjuk, hogy BUMM:</p>
<pre>if ( slot(1) === "B" ) {
    println("BUMM")
}</pre>
    <p>Ha nem teljesül a feltétel, csinálhatunk valami mást a különben = <code>else</code> utasítással. Ha a <code>nev</code> változóban a <code>"Domi"</code> szöveg van, kiírjuk, hogy Helló!, különben, hogy Domit kérem!:</p>
<pre><span class="text-body-tertiary">let nev = "Domi"</span>
if ( nev === "Domi") {
    println("Helló!")
} else {
    println("Domit kérem!")
}</pre>
    <p>Sőt, ha nem egy, és nem két lehetőség van, további <code>else if</code> utasításokat használhatunk. Pl. bekéri a program, hogy hanyas a matek témazáród, és 5-ös, 4-esnél megdicsér, különben (3, 2, 1) nem:</p>
<pre><span class="text-body-tertiary">let jegy = Number(prompt("Hanyas lett a matek témazáród?"))</span>
if ( jegy === 5 ) {
    println("WOW el se hiszem!")
    println("😀")
} else if ( jegy === 4 ) {
    println("Szép munka!")
} else {
    println("Hát, lehetne jobb!")
}</pre>
    <p>Figyeld meg, egy blokkban több utasítás is lehet. Amikor 5-öst kaptál, két sort is kiír.</p>
    <div class="alert alert-info" role="alert">
        <h6 class="alert-heading">Pro tipp</h6>
        <p>Ha csak egyetlen utasítás van az <code>if</code>, <code>else if</code> vagy <code>else</code> után, a kapcsos zárójelek el is hagyhatók:</p>
<pre><span class="text-body-tertiary">let nev = prompt("Hogy hívnak?")</span>
if ( nev === "Sanyi" )
    println("OK")
else
    println("Sanyi hoool vaaagy??")</pre>
    </div>
    <h3>Összehasonlítások</h3>
    <p>A <code>===</code> operátorral tudod ellenőrizni, hogy két érték ugyanaz-e. Pl. <code>nev === "Domi"</code> vagy <code>jegy === 3</code>. Figyeld meg, hogy ha szöveggel hasonlítasz össze, mindig ki kell rakni az idézőjeleket, ha számmal, akkor nem. Egy változó neve köré (itt <code>nev</code> és <code>jegy</code>) sosem kell idézőjel! Az összehasonlításokat pl. az <code>if</code> utasításban használhatod.</p>
    <p>Azt is leellenőrizheted, hogy két dolog nem egyenlő. Ehhez a <code>!==</code> operátor kell. Pl. ha nem jó jelszót írsz be, felrobbanunk:</p>
<pre><span class="text-body-tertiary">let jelszo = prompt("Mi a jelszó?")</span>
if ( jelszo !== "roblox" ) {
    println("BUMMM")
}</pre>
    <p>Van még néhány összehasonlítás: kisebb, nagyobb, kisebb vagy egyenlő, nagyobb vagy egyenlő: <code>&lt;</code>, <code>&gt;</code>, <code>&lt;=</code>, <code>&gt;=</code>. Pl. ha 2-est, vagy rosszabb jegyet kaptál, kapsz 9999 nap szobafogságot:</p>
    <pre><span class="text-body-tertiary">let jegy = Number(prompt("Hanyast kaptál?"))</span>
if ( jegy <= 2 ) {
    println("9999 nap szobafogság! Viszlát!")
}</pre>
    <h3>Változók</h3>
    <p>Elnevezhetsz, és lementhetsz valamit a memóriába a változókkal. Így hozhatsz létre egy <code>eletkor</code> nevű változót:</p>
<pre>let eletkor</pre>
    <p>De ez a változó még üres, nem mentettél bele semmit. Pl. kérjünk be egy szöveget és egy számot, és mentsük el a memóriába, hogy később ki tudjuk írni:</p>
<pre>let szoveg = prompt("Írj be egy szöveget!")
let szam = Number(prompt("Írj be egy számot!"))
print("Ezt a számot írtad be: ")
println(szam)
print("Ezt a szöveget írtad be: ")
println(szoveg)</pre>
    <p>Amikor változók nevét írjuk le, sosem rakunk köré idézőjelet! Próbáld ki, mi történne, ha <code>szoveg</code> helyett <code>"szoveg"</code>-et írnál!</p>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
    <script src="/js/knowledgebase.js"></script>
</body>
</html>
