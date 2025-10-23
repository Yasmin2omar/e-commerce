<?php
session_start();
use App\Review;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   
    $product_id = $_POST['product_id'] ?? null;
    $rating     = $_POST['rating'] ?? null;
    $comment    = $_POST['comment'] ?? null;
    $user_id = $_SESSION['user']['id'] ?? null;

    if (isset($_SESSION['user'])) {
        $name  = $_SESSION['user']['name'] ?? 'Guest';
        $email = $_SESSION['user']['email'] ?? null;
    } else {
        $name  = $_POST['name'] ?? 'Guest';
        $email = $_POST['email'] ?? null;
    }

 
    if ($product_id && $rating && $comment && $name && $email) {

        $review = new Review($db);
        $success = $review->addReview($product_id, $user_id, $name, $email, $rating, $comment);

        if ($success) {
            $_SESSION['review_success'] = "Review added successfully!";

        } else {
            $_SESSION['error'] = " Failed to add your review.";
        }

    } else {
        $_SESSION['error'] = " Missing required fields!";
    }

  
    header("Location: index.php?page=product-details&id=$product_id");
    exit;
}