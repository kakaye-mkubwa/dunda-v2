<?php
include_once '../../Api/vendor/autoload.php';

use FootballBlog\Processors\PostsFunctions;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $categoryID = $_POST["category"];

    $postFunctions = new PostsFunctions();

    $output = json_decode($postFunctions->deleteCategory($categoryID),true);
    if ($output["error"] == "false"){
        ?>
        <hr><div class="alert alert-success"><p align="center"><strong>
                    <i class="fa info"></i> Success!</strong>
            </p></div>
        <?php
    }else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Error Processing Request!</strong>
                <?php echo $output['message']?></p></div>
        <?php
    }
}