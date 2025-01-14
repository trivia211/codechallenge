<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "/..");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/server.php";

class PlayersServer extends Server {
    function __construct() {
        parent::__construct(['ListServer']);
    }
}

class ListServer extends ActionServer {
   static function action() /* override */ { return null; }
   function hasAccess() /* override */ { return true; }

   protected function getAnswer() /* override */ {
      $s = dbh()->prepare("SELECT id, name FROM players ORDER BY name");
      $s->execute();
      return $s->fetchAll(PDO::FETCH_ASSOC);
   }
}

(new PlayersServer())->serve();

?>
