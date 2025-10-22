<?php

use App\Blog;

if($_SERVER['REQUEST_METHOD']=="POST"&& isset($_POST['create'])){
    $title=$_POST['title'];
    $short_description=$_POST['short_description'];
    $long_description=$_POST['long_description'];
    $image=$_FILES['image'];
    $newProduct=Blog::createBlog($db,$title,$short_description,$long_description,$image);
    header("location: index.php?page=blogs");
    exit;
}