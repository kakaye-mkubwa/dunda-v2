<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $dataHandle = new DataHandler();
    $sessionManager = new SessionManager();

    $firstname = $dataHandle->sanitizeData($_POST['first_name']);
    $lastname = $dataHandle->sanitizeData($_POST['last_name']);
    $username = $dataHandle->sanitizeData($_POST['username']);
    $email = $dataHandle->sanitizeData($_POST['email']);
    $description = $dataHandle->sanitizeData($_POST['description']);
    $bloggerID = $dataHandle->sanitizeData($_POST['blogger']);

    if ($firstname == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> First Name is required</strong>
                </p></div>
        <?php
    }elseif ($lastname == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Last Name is required</strong>
            </p></div>
        <?php
    }elseif ($username == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Username is required</strong>
            </p></div>
        <?php
    }elseif ($email == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Email is required</strong>
            </p></div>
        <?php
    }elseif ($description == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Description is required</strong>
            </p></div>
        <?php
    }else{
        $bloggerFunctions = new BloggersFunctions();
        $bloggerResponse = json_decode($bloggerFunctions->editBloggerDetails($username,$email,$firstname,$lastname,$description,$bloggerID),true);

        if ($bloggerResponse['error'] == 'false'){
            ?>
            <hr><div class="alert alert-success"><p align="center"><strong>
                        <i class="fa info"></i> Success!</strong>
                </p></div>
            <script>setTimeout(function(){ location.reload();}, 1000);</script>
            <?php
        }else{
            ?>
            <hr><div class="alert alert-danger"><p align="center"><strong>
                        <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                    <?php echo $bloggerResponse["message"];?></p></div>
            <?php
        }
    }

}else{
    ?>
    <hr><div class="alert alert-danger"><p align="center"><strong>
                <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
            Ooops! Something went wrong</p></div>
    <?php
}
