<?php

use App\Product;

if($_SERVER['REQUEST_METHOD']=="POST"&& isset($_POST['edit'])){
    $id=$_GET['id'];
    $product=Product::findByID($db,$id);
    $name=!empty($_POST['name'])?$_POST['name']:$product->getName();
   $category_id = isset($_POST['category_id']) && $_POST['category_id'] !== ""? (int)$_POST['category_id']: $product->getCategoryId();
    $price=!empty((float) $_POST['price'])?(float) $_POST['price']:$product->getPrice();
    $description=!empty($_POST['description'])?$_POST['description']:$product->getDescription();
    $stock=!empty($_POST['stock'])?$_POST['stock']:$product->getStock();
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
    } else {
        $image = $product->getImage();
    }
    $newProduct=Product::updateProduct($db,$id,$name,$price,$stock,$description,$category_id,$image);
    header("location: index.php?page=products");
    exit;
}