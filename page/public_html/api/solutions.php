<?php
if ( !defined('ROOT') )
   define('ROOT', __DIR__ . "/..");
require_once ROOT . "/private/config.php";
require_once ROOT . "/private/server.php";

class SolutionsServer extends Server {
    function __construct() {
        parent::__construct(['AddServer']);
    }
}

class AddServer extends ActionServer {
   static function action() /* override */ { return 'add'; }

   function hasAccess() /* override */ {
      return true;
   }


   protected function getAnswer() /* override */ {
      $this->parseParams();
      $this->assertCredentialsCorrect();
      $this->initExerciseId();
      $this->add();
      return true;
   }

   private $playerId;
   private $challengeName;
   private $exerciseNo;
   private $code;
   private $exerciseId;

   private function parseParams() {
      $this->playerId = Request::getMandatoryInt($_POST, 'playerId');
      $this->challengeName = Request::getMandatoryStr($_POST, 'challengeName', 30);
      $this->exerciseNo = Request::getMandatoryInt($_POST, 'exerciseNo');
      $this->code = Request::getMandatoryStr($_POST, 'code', 10000, 'keep');
   }

   private function assertCredentialsCorrect() {
      $password = Request::getMandatoryStr($_POST, 'password', 1000, 'keep');
      $s = dbh()->prepare("SELECT password FROM players WHERE id = :id");
      $s->bindValue(':id', $this->playerId, PDO::PARAM_STR);
      $s->execute();
      $row = $s->fetch(PDO::FETCH_ASSOC);
      if ( $row === false )
         throw new Exception("Player not found.");
      if ( !password_verify($password, $row['password']) )
         throw new Exception("Hibás jelszó!");
   }

   private function initExerciseId() {
      $s = dbh()->prepare("SELECT challengeExercises.id " .
         "FROM challengeExercises JOIN challenges ON challenges.id = challengeId " .
         "WHERE challenges.name = :challengeName AND no = :exerciseNo");
      $s->bindValue(':challengeName', $this->challengeName, PDO::PARAM_STR);
      $s->bindValue(':exerciseNo', $this->exerciseNo, PDO::PARAM_INT);
      $s->execute();
      $row = $s->fetch(PDO::FETCH_ASSOC);
      if ( $row === false )
         throw new Exception("Invalid challenge or exercise.");
      $this->exerciseId = $row['id'];
   }

   private function add() {
      $s = dbh()->prepare("INSERT INTO solutions (playerId, exerciseId, code) " .
         "VALUES (:playerId, :exerciseId, :code)");
      $s->bindValue(':playerId', $this->playerId, PDO::PARAM_INT);
      $s->bindValue(':exerciseId', $this->exerciseId, PDO::PARAM_INT);
      $s->bindValue(':code', $this->code, PDO::PARAM_STR);
      $s->execute();
   }
}

(new SolutionsServer())->serve();

?>
