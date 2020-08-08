<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $blogFunctions = new BloggersFunctions();
    $sessionManager = new SessionManager();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $memberID[] = json_decode($blogFunctions->getBloggerID($email),true);

    $output = json_decode($blogFunctions->login($email,$password),true);
    if ($output['error'] == "false"){

        session_start();
        $_SESSION['id'] = $memberID[0]['id'];
        $sessionManager->startSession($memberID[0]['id']);
//        header("Location: ../index.php");
        //success and redirect
        ?><hr><div class="alert alert-success"><p align="center"><strong>
                    <i class="fa info"></i> Success!</strong>
                 </p></div>
        <script>setTimeout(function(){ window.location.href= 'index.php';}, 1000);</script>
        <?php
    } else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo $output['message']?></p></div>
        <?php
    }


}else{
    ?>
    <hr><div class="alert alert-danger"><p align="center"><strong>
                <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
            Ooops! Something went wrong</p></div>
    <?php
}
