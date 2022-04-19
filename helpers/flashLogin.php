<?php
if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
  foreach ($_SESSION['error'] as $error) {
    echo '<p class="error-msg"><b>' . $error . '</b></p>';
  } 
}
unset($_SESSION['error']);

if (isset($_SESSION['new-user'])) {
  echo '<p class="success-msg">' . $_SESSION['new-user'] . '</p>';
}
unset($_SESSION['new-user']);