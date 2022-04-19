<?php
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
  foreach ($_SESSION['error'] as $error) {
    echo '<p class="error-msg"><b>' . $error . '</b></p>';
  } 
}
if (isset($_SESSION['warning']) && !empty($_SESSION['warning'])) {
  foreach ($_SESSION['warning'] as $warning) {
    echo '<p class="warning-msg">' . $warning . '</p>';
  }
}
if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
  foreach ($_SESSION['success'] as $success) {
    echo '<p class="success-msg">' . $success . '</p>';
  }
}

if (isset($error)){
  unset($error);
}
if (isset($warning)){
  unset($warning);
}
if (isset($success)){
  unset($success);
}

unset($_SESSION['error']);
unset($_SESSION['warning']);
unset($_SESSION['success']);