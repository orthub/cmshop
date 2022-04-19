<?php
require_once __DIR__ . '/../helpers/session.php';
unset($_SESSION['totalPrice']);
unset($_SESSION['deliveryId']);
unset($_SESSION['deliveryAddressId']);
unset($_SESSION['order_id']);
unset($_SESSION['base-order']);
unset($_SESSION['products-from-order']);
unset($_SESSION['order-products-quantity']);
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <div class="container">
    <div class="space-mid"></div>
    <div class="text-center">
      <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
    </div>
    <div class="space-small"></div>

    <div class="row">
      <div class="col-4"></div>
      <div class="col-4 text-center">
        <h2>Danke für Ihre Bestellung.</h2>
        <p>Ihre Rechnung erhalten sie in kürze per Email.</p>
        <p>Sie können die Rechnung jederzeit bei ihren <a href="/views/orders.php">Bestellungen</a> einsehen und herunterladen.</p>
        <div class="space-mid"></div>
        <a href="/views/products.php">Weiter Einkaufen?</a>
      </div>
      <div class="col-4"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>