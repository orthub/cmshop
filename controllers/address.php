<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $delivery_id = trim(filter_input(INPUT_POST, 'deliveryId', FILTER_SANITIZE_SPECIAL_CHARS));
  $_SESSION['deliveryId'] = $delivery_id;
  
  header('Location: ' . '/views/checkout.php');
}