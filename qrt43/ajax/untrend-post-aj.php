<?php
include_once '../../Api/vendor/autoload.php';

use FootballBlog\Processors\PostsFunctions;
use FootballBlog\Models\DataHandler;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $dataHandler = new DataHandler();
    $postsFunctions = new PostsFunctions();

    $postID = $dataHandler->sanitizeData($_POST['id']);

    $output = json_decode($postsFunctions->untrendPosts($postID),true);
    if ($output['error'] == 'false'){
        ?>Success<script>location.reload();</script><?php
    }else{
        ?>Failed untrending post<?php
    }

}