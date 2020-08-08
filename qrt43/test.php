<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../api/vendor/autoload.php';

use FootballBlog\Processors\BloggersFunctions;
use FootballBlog\Processors\SessionManager;
use FootballBlog\Processors\PostsFunctions;

session_start();
$sessionHandle = new SessionManager();
$postsFunctions = new PostsFunctions();
$bloggerFunctions = new BloggersFunctions();

$sessionID = $_SESSION['id'];

$outputCategories = json_decode($postsFunctions->fetchCategories(),true);
$bloggerPosts = json_decode($postsFunctions->fetchPostsByBlogger($sessionID),true)['data'];

print_r($bloggerPosts);