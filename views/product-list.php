<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/productList.php';
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>

  <div class="space-mid"></div>
  <div class="content">
    <div class="text-center">
      <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
    </div>
    <div class="space-small"></div>

    <table>
      <thead>
        <tr>
          <th></th>
          <th>Titel</th>
          <th>Beschreibung</th>
          <th>Kategorie</th>
          <th>Lagernd</th>
          <th>Preis</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($all_products as $product) : ?>
        <tr>
          <td><img class="dash-img" src="<?php echo $product['img_url'] ?>" alt="<?php echo $product['slug'] ?>">
          </td>
          <td><?php echo $product['title'] ?></td>
          <td><?php echo $product['description'] ?></td>
          <td><?php echo $product['cat'] ?></td>
          <td class="text-center"><?php echo $product['quantity'] ?></td>
          <td><?php echo $product['price'] / 100 . '€' ?></td>
          <td><?php echo $product['status'] ?></td>
          <td>
            <?php echo ($product['status'] === 'LIVE') ?'<i class="fa-solid fa-circle green"></i>' :'<i class="fa-solid fa-circle red"></i>' ?>
          </td>
          <td>
            <form action="/controllers/editProduct.php" method="POST">
              <input type="hidden" name="edit-product" value="<?php echo $product['slug'] ?>">
              <input class="button" type="submit" value="Bearbeiten">
            </form>
          </td>
          <td>
            <?php if ($role === 'ADMIN') : ?>
            <form action="/controllers/deleteProduct.php" method="POST">
              <input type="hidden" name="delete-product" value="<?php echo $product['id'] ?>">
              <input class="button-delete" type="submit" value="Löschen">
            </form>
            <?php endif ?>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>