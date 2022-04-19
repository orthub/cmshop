<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../models/addresses.php';

$user_id = $_SESSION['user_id'];
$deliveryAddress = get_delivery_address($user_id);