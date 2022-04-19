<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once __DIR__ . '/../helpers/session.php';
  require_once __DIR__ . '/../models/invoice.php';
 
  $order_id = trim(filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS));
  $user_id = $_SESSION['user_id'];
  
  $get_base_order = get_order_with_user_and_order_id($user_id, $order_id);
  $get_products_from_order = get_products_for_order($order_id);

  $_SESSION['order-products-quantity'] = $get_products_from_order;

  $counting = count($get_products_from_order) - 1;

  $products = [];
  for ($count = 0; $count <= $counting; $count++) {
    $products[] = get_product_order_info($get_products_from_order[$count]['product_id']);
    $products[$count]['quantity'] = $get_products_from_order[$count]['quantity'];
  }

  $_SESSION['products-from-order'] = $products;
  $_SESSION['base-order'] = $get_base_order;

  $end_price = 0;
  header('Location: ' . '/views/invoice.php');
  
}