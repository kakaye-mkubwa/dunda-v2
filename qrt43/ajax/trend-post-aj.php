<?php
include_once '../../api/vendor/autoload.php';

use FootballBlog\Processors\PostsFunctions;
use FootballBlog\Models\DataHandler;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $dataHandler = new DataHandler();
    $postsFunctions = new PostsFunctions();

    $postID = $dataHandler->sanitizeData($_POST['id']);

    $output = json_decode($postsFunctions->setTrendingPosts($postID),true);

    if ($output["error"] == "false"){
        ?>
        <hr><div class="alert alert-success"><p align="center"><strong>
                    <i class="fa info"></i> Success!</strong>
            </p></div>
        <script>location.reload();</script>
        <?php
    }else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo "Failed trending post";?></p></div>
        <?php
    }
}
