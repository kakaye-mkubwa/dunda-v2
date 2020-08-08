<?php

include_once '../../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $dataHandler = new DataHandler();
    $bloggerFunctions = new BloggersFunctions();
    $postID = $dataHandler->sanitizeData($_POST['id']);

    $output = json_decode($bloggerFunctions->unpublishPost($postID),true);

    if ($output['error'] == "false"){
        ?>
        <hr><div class="alert alert-success"><p align="center"><strong>
                    <i class="fa info"></i> Success!</strong>
            </p></div>
        <?php
    }else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Publishing post failed".$output["message"];?></p></div>
        <?php
    }
}