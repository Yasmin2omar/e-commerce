<?php

use App\Blog;

if($_SERVER['REQUEST_METHOD']=="POST"&& isset($_POST['edit'])){
    $id=$_GET['id'];
    $blog=Blog::getBlogById($db,$id);
    $title=!empty($_POST['title'])?$_POST['title']:$blog['Title'];
    $short_description = isset($_POST['short_description']) && $_POST['short_description'] !== ""?$_POST['short_description']: $blog['short_description'];
    $long_description=!empty($_POST['long_description'])? $_POST['long_description']:$blog['long_description'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
    } else {
        $image = $blog['image'];
    }
    $newblog=Blog::updateBlog($db,$id,$title,$short_description,$long_description,$image);
    header("location: index.php?page=blogs");
    exit;
}