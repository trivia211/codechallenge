<?php
if ( !defined('ROOT') )
    define('ROOT', __DIR__ . "/..");
require_once ROOT . "/private/db.php";
require_once ROOT . "/private/request.php";

class ServerError extends Exception {
    // flags can include 'htmlMessage' and 'htmlTitle'
    function __construct($message, $title = null, $flags = []) {
        parent::__construct($message);
        $this->title = $title;
        $this->flags = $flags;
    }

    function getTitle() {
        return $this->title;
    }

    function isMessageHtml() {
        return in_array('htmlMessage', $this->flags, true);
    }

    function isTitleHtml() {
        return in_array('htmlTitle', $this->flags, true);
    }


    private $title;
    private $flags;
}

class AccessDenied extends Exception {
    function __construct($message = "Hozzáférés megtagadva.") {
        parent::__construct($message);
    }
}

class Server {
    // $serverClasses is a list of class names of ActionServer
    function __construct($serverClasses) {
        $this->serverClasses = $serverClasses;
    }

    function serve() {
        try {
            dbh()->exec("SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");
            dbh()->exec("START TRANSACTION");
            $action = $this->getAction();
            $this->serveByAction($action);
            dbh()->exec("COMMIT");
        } catch ( Exception $e ) {
            try { dbh()->exec("ROLLBACK"); } catch ( Exception $e2 ) { }
            http_response_code($e instanceof AccessDenied ? 403 : 500);
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode($this->getErrorResponse($e));
        }
    }


    private $serverClasses;

    private function getAction() {
        $result = Request::getStr($_GET, 'action', 50);
        if ( $result === null )
            $result = Request::getStr($_POST, 'action', 50);
        return $result;
    }

    private function serveByAction($action) {
        $server = $this->getServer($action);
        if ( $server->hasAccess() !== true )
            throw new AccessDenied();
        $server->serve();
    }

    private function getServer($action) {
        foreach ( $this->serverClasses as $serverClass ) {
            $serverAction = $serverClass::action();
            if ( $serverAction === -1 )
                throw new Exception("Unset action for server: " . $serverClass . ".");
            if ( $serverAction === $action )
                return new $serverClass;
        }
        if ( $action !== null)
            throw new Exception("Invalid action: " . $action . ".");
        else
            throw new Exception("Missing action.");
    }

    function getErrorResponse($e) {
        if ( $e instanceof ServerError ) {
            $result = array('message'=>$e->getMessage());
            if ( $e->isMessageHtml() )
                $result['htmlMessage'] = true;
            if ( $e->getTitle() !== null )
                $result['title'] = $e->getTitle();
            if ( $e->isTitleHtml() )
                $result['htmlTitle'] = true;
            return $result;
        } else
            return $e->getMessage();
    }
}

abstract class ActionServer {
    // returns the action string the server is associated with. can return null to serve requests
    // without an action. -1 means not implemented.
    static function action() /* virtual */ { return -1; }
    abstract function hasAccess();

    function serve() /* virtual */ {
        $answer = $this->getAnswer();
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($answer);
    }


    protected function getAnswer() /* virtual */ { return null; }
}

?>
