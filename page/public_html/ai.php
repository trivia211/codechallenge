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
    <link href="/css/ai.css" rel="stylesheet">
</head>
<body>
    <?php echo Snippets::navbar('challenge'); ?>
    <div class="container"><div class="row"><div class="col">
        <h1>Programozás AI segéddel</h1>
        <ol>
            <li>Visual Studio Code (VS-Code) fejlesztői környezet megnyitása.</li>
            <li>Copilot AI programozótárs engedélyezése: Set up Copilot.</li>
            <li>Github fiók regisztrálása, majd összekapcsolása a VS Code-dal.</li>
            <li>Copilot beállítása:
                <ul>
                    <li>Jobb alsó sarokban a Copilot ikonra kattintás, Code Completions, kivenni a pipát az All-ból.</li>
                    <li>Chat megnyitása: Ctrl + Alt + I</li>
                    <li>Legördülő menükből: Agent mód, és a legújabb verziójú Claude Sonnet beállítása.</li>
                </ul>
            </li>
            <li>Mappa megnyitása, ahová a kódfájlokat létre fogjuk hozni. Már létrehoztam egy mappát erre: Dokumentumok/html. Nyissuk meg ezt a mappát.</li>
            <li>Bal oldal: kódfájlok, közép: kódszerkesztő, jobb oldal: AI chat.</li>
            <li>A bal oldalon hozzunk létre egy új <code>img</code> nevű mappát, ide fogjuk tenni a képeket.</li>
            <li>Játékötlet kitalálása. Te mit fogsz készíteni?
                <img src="/img/ai/gameideas.png" class="img-fluid my-2">
            </li>
            <li>Prompt elkészítése a játékhoz. Minél egyszerűbb legyen a kiindulás, és lépésenként adjuk hozzá a funkciókat. Másoljuk be ezt első mondatnak, majd egészítsük ki a saját ötletünkkel:
                <blockquote class="blockquote">
                    <p>Készíts egy webes játékot JavaScript, HTML és CSS használatával a következő leírás alapján. <i>Írjuk ide az ötletünket!</i></p>
                </blockquote>
            </li>
            <li>Figyeljük meg, hogy ahogy dolgozik az AI, a bal oldalon létrejönnek új fájlok. Ha készen van, nyissuk meg őket, nézzük meg, mi van bennük. A legérdekesebb a JavaScript (<code>.js</code>) fájl lesz. Kattintsunk a Keep gombra.</li>
            <li>Nyissuk meg az új játékot egy böngészőben! Keressük meg a Dokumentumok/html/index.html fájlt, jobb gombbal kattintsunk rá, Megnyitás ezzel, és válasszunk ki egy böngészőt.</li>
            <li>Működik a játék? Szeretnénk továbbfejleszteni? Akkor menjünk vissza a VS-Code-ba, és a chatben írjuk le az igényünket.</li>
            <li>Próbáljunk lépésenként haladni, egyszerre mindig csak egy kisebb fejlesztést kérni.</li>
            <li>Miután elkészült az új fejlesztés, még <b>ne</b> kattintsunk a Keep gombra. Először próbáljuk ki, működik-e a játék. Menjünk vissza a böngészőbe, és frissítsük az oldalt az F5 gombbal. (Vagy ha nem frissül: Ctrl + F5.)</li>
            <li>Ha minden jó, rákattinthatunk a Keep gombra. Ha vannak még kisebb problémák, a chat-ben kérjünk javítást, egészen, amíg minden jó nem lesz. Ha egyáltalán nem sikerül a dolog, esetleg a játék teljesen elromlott, kattintsunk az Undo gombra, és vonjuk vissza az összes változtatást. Majd próbálkozzunk újra máshogy.</li>
            <li>Ha a játék nem működik, leáll, a böngészőben nyissuk meg a fejlesztői konzolt az F12 gombbal, és a Konzol oldalon keressünk piros hibaüzeneteket. Ha találunk ilyet, másoljuk be őket a chat-be, és kérjünk javítást.</li>
            <li>
                Ha nem tetszik a grafika, és saját képet szeretnénk beilleszteni, hozzuk létre a képet az img mappában, majd a chat-ben kérjük meg, hogy mostantól ezt a képet használja a játék. Adjuk meg pontosan a kép nevét a kiterjesztéssel együtt.
                <ul>
                    <li>Emlékeztető, ha átlátszó hátterű képet szeretnénk:</li>
                    <li>A Google képkeresőjében használjuk az Eszközök / Típus / ClipArt-képet.</li>
                    <li>Vagy, ha mi magunk szeretnénk kivágni a hátteret, töltsük le a képet, és használjuk a GIMP programot.</li>
                    <li>Itt a varászpálca eszközre lesz szükségünk. Ha túl sokat / túl keveset vág ki, állítsuk a Küszöb értékét.</li>
                    <li>Ha átlátszó helyett fehér lesz a háttér, adjuk hozzá az alfa csatornát: Réteg / Átlátszóság / Alfa csatorna hozzáadása.</li>
                    <li>Használjuk a Kép / Vágás a tartalomhoz funkciót, hogy eltávolítsuk az üres részeket a kép szélén.</li>
                    <li>A képet png formátumban mentsük el. Ha már png, akkor a Fájl menüben a ....png felülírása opciót válasszuk. Különben az Exportálás menüpontot, és .png kiterjesztéssel mentsük el a képet. A képet az img mappába mentsük!</li>
                    <li>Ha belenéztünk a kódba, és találtunk valami érdekeset, amit meg szeretnénk változtatni, hajrá! De a változtatás után el kell menteni a fájlt a Ctrl + S lenyomásával. Ezután a böngészőben frissítsük az oldalt.</li>
                </ul>
            </li>
            <li>Próbáljuk ki mobilon is a játékunkat. Kérjük meg, hogy tegye irányíthatóvá mobilról is!</li>
        </ol>
    </div></div></div>
    <?php echo Snippets::foot(); ?>
</body>
</html>
