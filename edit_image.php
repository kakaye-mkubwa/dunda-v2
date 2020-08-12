<?php
include_once 'includes/header.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$allPosts = json_decode($postsFunctions->fetchAllPosts(),true);
foreach ($allPosts['data'] as $posts){
    $postsFunctions->updateImageURL(substr($posts['image_url'],27),$posts['post_id']);
}