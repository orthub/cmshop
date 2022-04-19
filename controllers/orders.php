<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../models/orders.php';

$user_id = $_SESSION['user_id'];

$orders = get_order_overview_for_user($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $order_id = trim(filter_input(INPUT_POST, 'order_id', FILTER_SANITIZE_SPECIAL_CHARS));
  require_once __DIR__ . '/../helpers/session.php';
  require_once __DIR__ . '/invoice.php';
}