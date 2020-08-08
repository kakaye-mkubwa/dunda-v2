<?php
namespace FootballBlog\Models;

class DataHandler{

    public function sanitizeData($data){
         return htmlspecialchars(htmlentities(htmlspecialchars(strip_tags(trim($data)))));
    }

    public function sanitizeDescription($data){
        return trim(strip_tags($data,"<p><br><blockquote><cite><b><i>"));
    }
}