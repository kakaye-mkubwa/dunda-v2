<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../api/vendor/autoload.php';

use FootballBlog\Processors\SessionManager;
use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $dataHandle = new DataHandler();
    $bloggerFunctions = new BloggersFunctions();

    // $postContent = $dataHandle->sanitizeData($_POST['content']);
    $postContent = $_POST['post_content'];
    $postDescription = $dataHandle->sanitizeData($_POST['description']);
    $postTitle = $dataHandle->sanitizeData($_POST['title']);
    $postCategory = $dataHandle->sanitizeData($_POST['category']);
    $postID = $dataHandle->sanitizeData($_POST['post']);



    $editPostOutput = json_decode($bloggerFunctions->editPostDetails($postID,$postTitle,$postDescription,$postContent,$postCategory),true);

    if ($editPostOutput['error'] == "false"){
        ?><hr><div class="alert alert-success"><p align="center"><strong>
                    <i class="fa info"></i> Success!</strong>
            </p></div>
        <script>setTimeout(function(){ window.location.href='manage-posts.php';}, 1000)</script>
        <?php
    }else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo $editPostOutput['message']?></p></div>
        <?php

    }
}