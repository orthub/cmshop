<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/orders.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <div class="content">
    <div class="space-mid"></div>

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <h2>Bestellübersicht:</h2>
        <div class="space-small"></div>
        <?php foreach($orders as $order) : ?>
        <p>Bestell Nummer: <b><?php echo $order['orders_id'] ?></b></p>
        <p>Bestell Datum: <b><?php echo date('d.m.Y', strtotime($order['order_date'])) ?></b></p>
        <p>Bestell Status: <b><?php echo ($order['status'] === 'new') ? 'Zahlung noch nicht eingegangen' : ''?></b></p>
        <br />
        <form action="/controllers/invoice.php" method="POST">
          <input type="hidden" name="order_id" value="<?php echo $order['orders_id'] ?>">
          <input class="button" type="submit" name="invoice" value="Rechnung ansehen">
        </form>
        <div class="space-small"></div>
        <hr />
        <div class="space-mid"></div>
        <?php endforeach ?>
      </div>
      <div class="col-4"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>