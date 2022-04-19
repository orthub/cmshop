<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $delivery_id = trim(filter_input(INPUT_POST, 'deliveryId', FILTER_SANITIZE_SPECIAL_CHARS));
  $_SESSION['deliveryId'] = $delivery_id;
  
  require_once __DIR__ . '/../models/checkout.php';
  require_once __DIR__ . '/../models/cart.php';
  
  $delivery_name = username_for_order($user_id);
  $delivery_address = delivery_address_for_order($user_id, $delivery_id);
  
  $_SESSION['checkout']['deliveryAddress'] = $delivery_address;
  $_SESSION['checkout']['deliveryName'] = $delivery_name;
  
  $total_price = $_SESSION['totalPrice'] * 100;
  
  // erzeugen einer zufallszahl für die bestellung
  $random_order_id = date('dmYHi');
  // bestellungs id zusammensetzen mit der zufallszahl und user id
  $order_id = $random_order_id . $user_id;
  $_SESSION['order_id'] = $order_id;
  
  // bestellung speichern
  $save_order = save_order($user_id, $order_id, $delivery_id, $total_price);  
  
  // produkte vom warenkorb speichern
  $save_order_products = save_order_products($user_id, $order_id);
  
  // warenkorb leeren
  $delete_cart_products = delete_products_from_cart($user_id);
 
  
  unset($order_id);
  unset($total_price);
  unset($user_id);

  header('Location: ' . '/views/checkout.php');
}