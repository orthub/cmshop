<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

require_once __DIR__ . '/../models/cart.php';

$user_id = $_SESSION['user_id'];
$product_id = trim(filter_input(INPUT_POST, 'productId', FILTER_SANITIZE_SPECIAL_CHARS));
$get_quantity = get_quantity_from_cart($product_id);

$removeItem = remove_product_from_cart($user_id, $product_id, $get_quantity);

header('Location: ' . '/views/cart.php');