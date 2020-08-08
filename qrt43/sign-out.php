<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;

session_start();
$sessionID = $_SESSION['id'];

$blogFunctions = new BloggersFunctions();
$sessionManager = new SessionManager();
$dataHandle = new DataHandler();

if ($sessionManager->checkSessionExists($sessionID)){
    if ($sessionManager->stopSession($sessionID)){
        session_start();

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        ?>
        <script>window.location.href= 'sign-in.html';</script>
        <?php
    }else{
        ?>
        <script>window.location.href= 'index.php';</script>
        <?php
    }
}else{
    session_start();

    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
    ?>
    <script>
        console.log("Session not existing");
        window.location.href= 'sign-in.html';
    </script>
    <?php
}