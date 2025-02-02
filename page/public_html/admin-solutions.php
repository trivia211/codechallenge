<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/request.php";
require_once ROOT . "/private/db.php";

try {
    if ( Request::getStr($_GET, 'auth') !== "m31cxJEtqOPErJa" )
        exit("Access denied.");
} catch ( ParamsError $e ) {
    exit("Access denied.");
}

$s = dbh()->prepare("SELECT players.name, addTime, challenges.title, challengeExercises.no, code " .
    "FROM solutions JOIN players ON players.id = playerId " .
        "JOIN challengeExercises ON challengeExercises.id = exerciseId " .
        "JOIN challenges ON challenges.id = challengeId " .
    "ORDER BY addTime DESC");
$s->execute();

while ( ($row = $s->fetch(PDO::FETCH_ASSOC)) !== false )
    echo htmlspecialchars($row['name']) . ", " . htmlspecialchars($row['addTime']) . ", " .
        htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['no']) . ".<br>" .
        "<pre>" . htmlspecialchars($row['code']) . '</pre>';

?>
