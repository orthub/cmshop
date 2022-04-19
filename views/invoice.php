<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/invoice.php';
require_once __DIR__ . '/../config/company_data.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <div class="content">
    <div class="space-small"></div>

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <a href="/views/orders.php">Zurück zur Übersicht</a>
        <div class="space-small"></div>
        <h2>Rechnung:</h2>
        <hr />
      </div>
      <div class="col-2"></div>
    </div>

    <div class="row">
      <div class="col-2">
      </div>
      <div class="col-8">
        <p>Bestell Nummer: <b><?php echo $_SESSION['base-order']['orders_id'] ?></b></p>
        <p>Bestell Datum: <b><?php echo date('d.m.Y', strtotime($_SESSION['base-order']['order_date'])) ?></b></p>
        <p>Bestell Status:
          <b><?php echo ($_SESSION['base-order']['status'] === 'new') ? 'Zahlung noch nicht eingegangen' : 'Bezahlt' ?></b>
        </p>
      </div>
      <div class="col-2"></div>
    </div>

    <div class="row">
      <div class="col-2">
      </div>
      <div class="col-8">
        <h2>Produkte:</h2>
        <br />
        <table class="no-table-style">
          <thead>
            <tr>
              <th>Produkt:</th>
              <th>Stück:</th>
              <th>Preis:</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <?php foreach ($_SESSION['products-from-order'] as $value) : ?>
            <tr>
              <td><?php echo $value['title'] ?></td>
              <td><?php echo $value['quantity'] ?></td>
              <td><?php echo $value['price'] / 100 . '€'?></td>
            </tr>
            <?php endforeach ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td class="text-right">Versandkosten:</td>
              <td></td>
              <td>2.55€</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-2"></div>
    </div>

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <h2>Gesamtpreis (inkl. MwSt) und Versand: <?php echo ($_SESSION['base-order']['order_price']) / 100 . '€' ?></h2>
        <hr />
        <br />
        <form action="/controllers/downloadInvoice.php" method="POST">
          <input type="hidden" name="order_id" value="<?php echo $_SESSION['base-order']['orders_id'] ?>">
          <input type="hidden" name="endprice" value="<?php echo $_SESSION['base-order']['order_price'] ?>">
          <input class="button" type="submit" name="invoice" value="Rechnung herunterladen">
        </form>
      </div>
      <div class="col-2"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>