<?php

include_once '../../Api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;
use FootballBlog\Models\DataHandler;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $blogFunctions = new BloggersFunctions();
    $sessionManager = new SessionManager();
    $datahandle = new DataHandler();

    $category = $_POST['category'];

    $output = json_decode($blogFunctions->addCategory($category),true);

    if ($output['error'] == "false"){
    ?>
        <hr><div class="alert alert-success"><p align="center">
            <strong><i class="fa info"></i> Success!</strong>
            </p></div>
    <?php
    }else{
        ?>
        <hr><div class="alert alert-danger"><p align="center"><strong>
                    <i class="fa fa-exclamation-triangle"></i> Failed adding category!</strong>
                <?php echo $output['message'];?></p></div>
        <?php
    }
}