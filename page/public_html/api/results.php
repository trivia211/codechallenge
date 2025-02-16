<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "/..");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/server.php";
require_once ROOT . "/private/badges.php";

class ResultsServer extends Server {
    function __construct() {
        parent::__construct(['ListServer']);
    }
}

class ListServer extends ActionServer {
   static function action() /* override */ { return null; }
   function hasAccess() /* override */ { return true; }


   protected function getAnswer() /* override */ {
      return array(
         'players'=>$this->getPlayers(),
         'challenges'=>$this->getChallenges(),
         'results'=>$this->getResults(),
         'badges'=>$this->getBadges()
      );
   }

   private function getPlayers() {
      $s = dbh()->prepare("SELECT id, name FROM players ORDER BY name");
      $s->execute();
      return $s->fetchAll(PDO::FETCH_ASSOC);
   }

   private function getChallenges() {
      $s = dbh()->prepare("SELECT id, name, title FROM challenges ORDER BY id DESC");
      $s->execute();
      return $s->fetchAll(PDO::FETCH_ASSOC);
   }

   private function getResults() {
      $s = dbh()->prepare("SELECT playerId, challengeId, result FROM results ORDER BY id");
      $s->execute();
      $result = array();
      while ( ($row = $s->fetch(PDO::FETCH_ASSOC)) !== false )
         $result[$row['playerId']][$row['challengeId']] = $row['result'];
      return $result;
   }

   private function getBadges() {
      $widths = Badges::getProportionalWidhts();
      $result = array();
      foreach ( Badges::LIST as $id=>$img )
         $result[$id] = array('img'=>$img, 'width'=>$widths[$id]);
      return $result;
   }
}

(new ResultsServer())->serve();

?>
