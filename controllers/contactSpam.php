<?php
require_once __DIR__ . '/../helpers/session.php';

$number_1 = rand(1, 9);
$number_2 = rand(1, 9);
$choose_calculation = rand(0, 1);
$calculation = ['+', '*'];

switch ($choose_calculation) {
  case 0:
    $calc = $number_1 + $number_2;
    break;
  case 1:
    $calc = $number_1 * $number_2;
    break;
}

$spam_protect = $number_1 . ' ' . $calculation[$choose_calculation] . ' ' . $number_2;
$_SESSION['contact']['spam'] = $spam_protect;
$_SESSION['contact']['result'] = $calc;