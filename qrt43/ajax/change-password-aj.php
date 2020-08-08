<?php

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../api/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $dataHandle = new DataHandler();
    $bloggerFunctions = new BloggersFunctions();

    $oldPassword = $dataHandle->sanitizeData($_POST['old_password']);
    $newPassword = $dataHandle->sanitizeData($_POST['new_password']);
    $newPasswordConfirm = $dataHandle->sanitizeData($_POST['new_password_confirm']);
    $bloggerID = $dataHandle->sanitizeData($_POST['blogger']);

    if ($bloggerID == ""){
        ?>
        <script>setTimeout(function(){ window.location.href= 'sign-in.html';}, 1000);</script>
        <?php
    }elseif ($newPassword != $newPasswordConfirm){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                Confirm the new password correctly</p></div>
        <?php
    }elseif (!$bloggerFunctions->verifyPassword($bloggerID,$oldPassword)){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                Incorrect old password</p></div>
        <?php
    }else{
        $bloggerResponse = json_decode($bloggerFunctions->changeBloggerPassword($bloggerID,$oldPassword,$newPassword),true);

        if ($bloggerResponse['error'] == 'false'){
            ?>
            <hr><div class="alert alert-success"><p align="center"><strong>
                        <i class="fa info"></i> Success!</strong>
                </p></div>
            <script>setTimeout(function(){ location.reload()}, 1000);</script>
            <?php
        }else{
            ?>
            <hr><div class="alert alert-danger"><p align="center"><strong>
                        <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                    <?=$bloggerResponse['message']?></p></div>
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