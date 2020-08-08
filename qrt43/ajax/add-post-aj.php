<?php

include_once '../../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $dataHandle = new DataHandler();
    $title = $dataHandle->sanitizeData($_POST["title"]);
    $description = $dataHandle->sanitizeData($_POST["description"]);
    // $postContent = $dataHandle->sanitizeDescription($_POST["post_content"]);
    $postContent = $_POST["post_content"];
    $bloggerID = $dataHandle->sanitizeData($_POST["blogger"]);
    $postCategory = $dataHandle->sanitizeData($_POST["category"]);
    $imageFile = $dataHandle->sanitizeData($_FILES["image"]["tmp_name"]);
    $imageName = $dataHandle->sanitizeData($_FILES["image"]["name"]);
    $imageSize = $dataHandle->sanitizeData($_FILES["image"]["size"]);
    $imageFileExtension = pathinfo($imageName,PATHINFO_EXTENSION);

//    $dir = __DIR__;
//    $baseDir = substr($dir,0,26);
    $baseDir = $dir = __DIR__ . "/../..";
    // $baseDir = substr($dir,0,51);

    if ($title == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Article title is required";?></p></div>
        <?php
    }elseif ($description == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Article description is required";?></p></div>
        <?php
    }elseif ($postContent == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Article content is required";?></p></div>
        <?php
    }elseif ($bloggerID == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "You need to login";?></p></div>
        <?php
    }elseif ($postCategory == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Article category is required";?></p></div>
        <?php
    }elseif ($imageName == ""){
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Article image is required";?></p></div>
        <?php
    }else{
        if (!in_array($imageFileExtension,['png','jpeg','jpg','gif'])){
            ?>
            <hr><div class="alert alert-danger"><p align="center"><strong>
                        <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                    <?php echo "Image file extension not accepted";?></p></div>
            <?php
        }elseif ($imageSize > 10000000){

            ?>
            <hr><div class="alert alert-danger"><p align="center"><strong>
                        <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                    <?php echo "Image file should not be more than 10MB";?></p></div>
            <?php
        }else{

            $bloggerFunctions = new BloggersFunctions();
            $addingResponse = json_decode($bloggerFunctions->addPost($title,$description,$postContent,$bloggerID,$postCategory,$imageFile,$imageName,$baseDir),true);

            if ($addingResponse['error'] == 'false'){
                ?>
                <hr><div class="alert alert-success"><p align="center"><strong>
                            <i class="fa info"></i> Success!</strong>
                    </p></div>
                <script>setTimeout(function(){ location.reload();}, 1000)</script>
                <?php
            }else{
                ?>
                <hr><div class="alert alert-danger"><p align="center"><strong>
                            <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                        <?php echo $addingResponse["message"];?></p></div>
                <?php
            }
        }
    }

}
