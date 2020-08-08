<?php
include_once 'includes/header.php';
if (isset($_GET['date']) && isset($_GET['time']) && isset($_GET['slug'])){
    $date = $_GET['date'];
    $slug = $_GET['slug'];
    $time = $_GET['time'];

    $str = $date.$time;

    $time = strtotime($str);

    $dateformat = date('YmdHis',$time);
    $timeformat = date('His',$time);

    echo $dateformat.' date';
    echo '<br>';
    echo $timeformat.' date';

}else{
    include_once '404.php';
}
