<?php

use Cocur\Slugify\Slugify;

//include_once 'includes/header.php';


//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include_once 'api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\EncryptHandler;
use FootballBlog\Processors\PostsFunctions;

$postsFunctions = new PostsFunctions();
$encryptFunctions = new EncryptHandler();
$bloggerFunctions = new BloggersFunctions();

$postsOutput = json_decode($postsFunctions->fetchAllPublishedPostsMain(), true);
$outputCategories = json_decode($postsFunctions->fetchCategories(), true);
//$recentPostsOutput = json_decode($postsFunctions->fetchRecentPublishedPostsMain(),true);
$recentPostsOutput30Days = json_decode($postsFunctions->fetch30DayRecentPublishedPostsMain(), true);
$trendingPosts = json_decode($postsFunctions->fetchTrendingPostsMain(), true);
$popularTags = json_decode($postsFunctions->fetchPopularTags(), true);

$allPosts = json_decode($postsFunctions->fetchAllPosts(),true);
//print_r($allPosts);
foreach ($allPosts["data"] as $row){
    $slugify = new Slugify();
    $postSlug = $slugify->slugify($row['post_title']);

    $postsFunctions->insertSlug($postSlug,$row['post_id']);
}
