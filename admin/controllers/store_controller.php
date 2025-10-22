<?php

use App\Category;
use App\Product;

if($_SERVER['REQUEST_METHOD']=="POST"&& isset($_POST['create'])){
    $name=$_POST['name'];
    $category_id=(int) $_POST['category_id'];
    $price=(float) $_POST['price'];
    $description=$_POST['description'];
    $stock=$_POST['stock'];
    $image=$_FILES['image'];
    $newProduct=Product::createProduct($db,$name,$price,$description,$stock,$category_id,$image);
    header("location: index.php?page=products");
    exit;
}