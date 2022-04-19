<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

require_once __DIR__ . '/../models/cart.php';

$user_id = $_SESSION['user_id'];

$totalPrice = 0;
$cart_items = get_cart_products_for_user($user_id);
$no_items = false;
$no_items = count($cart_items);
if ($no_items === 0) {
  $no_items = true;
}