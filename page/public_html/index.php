<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/db.php";

$s = dbh()->prepare("SELECT name FROM challenges ORDER BY id LIMIT 1");
$s->execute();
$row = $s->fetch(PDO::FETCH_ASSOC);
if ( $row === false )
   exit("No challenges found.");
header("Location: /" . $row['name'] . ".php");
?>
