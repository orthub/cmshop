<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/cart.php';
?>

<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <div class="container">
    <?php require_once __DIR__ . '/partials/navbar.php' ?>
    <?php require_once __DIR__ . '/partials/userbar.php' ?>
    <div class="space-mid"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <?php if (count($cart_items) > 0) : ?>
        <h2>Warenkorb</h2>
        <div class="space-small"></div>
        <table class="no-table-style">
          <thead>
            <th>Produkt</th>
            <th>Stück</th>
            <th>Einzelpreis</th>
            <th>Preis</th>
            <th></th>
          </thead>
          <tbody>
            <?php foreach ($cart_items as $cart_item) : ?>
            <?php $total_price += $cart_item['price'] * $cart_item['quantity'] / 100 ?>
            <tr>
              <td><?php echo $cart_item['title'] ?></td>
              <td><?php echo $cart_item['quantity'] ?></td>
              <td><?php echo ($cart_item['price'] / 100) . '€' ?></td>
              <td><?php echo $cart_item['price'] / 100 * $cart_item['quantity'] . '€'  ?></td>
              <td>
                <form action="/controllers/removeFromCart.php" method="POST">
                  <input type="hidden" name="productId" value="<?php echo $cart_item['product_id'] ?>">
                  <input class="button" type="submit" value="Entfernen">
                </form>
              </td>
            </tr>
            <?php endforeach ?>
            <tr>
              <td>Versandkosten</td>
              <td></td>
              <td></td>
              <td>2,55€</td>
              <td></td>
            </tr>
            <?php $total_price = $total_price + 2.55 ?>
            <?php $_SESSION['totalPrice'] = $total_price ?>
          </tbody>
        </table>
        <div class="space-small"></div>
        <p><b>Gesamtkosten inkl. Versand: <?php echo $total_price ?>€</b></p>
      </div>
      <div class="col-3"></div>
    </div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <a href="/views/address.php">Lieferadresse auswählen/hinzufügen</a>
      </div>
      <div class="col-3"></div>
    </div>

    <?php else : ?>
    <h2>Ihr Warenkorb ist leer</h2>
    <div class="space-small"></div>
    <a href="/views/products.php">Hier geht es zu unseren Produkten</a>
    <?php endif ?>

    <div class="space-big"></div>
  </div>
  <?php require_once __DIR__ .'/partials/footer.php' ?>
</body>

</html>