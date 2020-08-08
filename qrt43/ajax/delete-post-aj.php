<?php

include_once '../../api/vendor/autoload.php';

use FootballBlog\Models\DataHandler;
use FootballBlog\Processors\BloggersFunctions;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $bloggerFunctions = new BloggersFunctions();
    $dataHandler = new DataHandler();

    $postID = $dataHandler->sanitizeData($_POST['id']);

    $output = $bloggerFunctions->deletePost($postID);
    if ($output['error'] == "false"){
        ?>
        <p>Success</p>
        <script>location.reload();</script>
        <?
    }else{
        ?>
        <p>Failed</p>
        <?php
    }
}
