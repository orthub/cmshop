<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../models/userRights.php';


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
  }

  $product_id = trim(filter_input(INPUT_GET, 'prodid', FILTER_SANITIZE_SPECIAL_CHARS));
  $product_status = trim(filter_input(INPUT_GET, 'current', FILTER_SANITIZE_SPECIAL_CHARS));
  $product_slug = trim(filter_input(INPUT_GET, 'slug', FILTER_SANITIZE_SPECIAL_CHARS));
  
  if ($product_status === 'LIVE'){
    $new_status = 'DRAFT';
    $change_product_status = change_product_status_by_id($product_id, $new_status);
    if ($change_product_status) {
      $_SESSION['edit-product']['status'] = 'DRAFT';
      header('Location: ' . '/views/editProduct.php');
      exit();
    }
  }
  
  if ($product_status = 'DRAFT') {
    $new_status = 'LIVE';
    $change_product_status = change_product_status_by_id($product_id, $new_status);
    if ($change_product_status) {
      $_SESSION['edit-product']['status'] = 'LIVE';
      header('Location: ' . '/views/editProduct.php');
      exit();
    }
  }
  
  } else {
    header('Location: ' . '/');
}