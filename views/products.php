<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../helpers/roles.php';
$products = get_all_live_products();

?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php unset($_SESSION['error']['email']) ?>
  <?php unset($_SESSION['error']['password']) ?>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <?php echo (isset($_SESSION['new-product']) ? '<p class="text-center success-msg">' . $_SESSION['new-product'] . '</p>' : '' ) ?>
  <?php unset($_SESSION['new-product']) ?>
  <div class="space-big"></div>
  <div class="content">

    <div class="row">
      <?php foreach($products as $product) : ?>
      <div class="col-3">
        <p class="text-bold"><?php echo $product['title'] ?></p>
        <img class="product-img" src="<?php echo $product['img_url'] ?>" alt="<?php echo $product['slug'] ?>">
        <p><?php echo $product['price'] / 100 . '€' ?></p>
        <?php echo ($product['quantity'] === 0) ? '' : '<p>Lagernd: ' . $product['quantity'] . '</p>' ?>
        <?php if ($product['quantity'] >= 1) : ?>
        <form action="/../controllers/addToCart.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $product['id'] ?>" />
          <input class="button" type="submit" value="In den Warenkorb" />
        </form>
        <?php if (isset($role) && $role !== 'CUSTOMER') : ?>
        <form action="editProduct.php" method="POST">
          <input type="hidden" name="edit-product" value="<?php echo $product['slug'] ?>" />
          <input class="button-edit" type="submit" value="Bearbeiten">
        </form>
        <?php endif ?>
        <?php endif ?>
        <?php if ($product['quantity'] === 0) : ?>
        <p class="text-danger">Ausverkauft</p>
        <?php endif ?>
      </div>
      <?php endforeach ?>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>