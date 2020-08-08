<?php

use Cocur\Slugify\Slugify;

include_once 'includes/header.php';

$allPosts = json_decode($postsFunctions->fetchAllPosts(),true);
//print_r($allPosts);
foreach ($allPosts["data"] as $row){
    $slugify = new Slugify();
    $postSlug = $slugify->slugify($row['post_title']);

    $postsFunctions->insertSlug($postSlug,$row['post_id']);
}
