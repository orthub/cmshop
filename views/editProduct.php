<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/editProduct.php';
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <div class="content">
    <div class="space-mid"></div>
    <div class="text-center">
      <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
    </div>
    <div class="space-small"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <div class="text-center">
          <a href="/controllers/productStatus.php?prodid=<?php echo $_SESSION['edit-product']['id'] . '&current=' . $_SESSION['edit-product']['status'] . '&slug=' . $_SESSION['edit-product']['slug'] ?>">
            <button class="<?php echo ($_SESSION['edit-product']['status'] === 'LIVE') ? 'button-live' : 'button-draft' ?>">Status: <?php echo $_SESSION['edit-product']['status'] ?></button>
          </a>
        </div>
        <div class="space-small"></div>
        <div class="row">
          <div class="col-6">
            <p>Produktbild hochladen:</p>
            <form action="/controllers/uploadProductImage.php" method="POST" enctype="multipart/form-data">
              <input type="file" name="product-image"><br>
              <input class="button" type="submit" value="Hochladen">
            </form>
          </div>
          <div class="col-6">
            <p>Aktuelles Produktbild:</p>
            <img class="product-img" src="<?php echo $_SESSION['edit-product']['img_url'] ?>" />
          </div>
        </div>
        <form action="/controllers/editProductSave.php" method="POST">
          <label for="">Titel</label>
          <input type="text" name="title" value="<?php echo $_SESSION['edit-product']['title'] ?>"><br /><br />
          <label for="des">Beschreibung</label>
          <textarea id="des" name="description"><?php echo $_SESSION['edit-product']['description'] ?></textarea><br />
          <label for="">Kategorie (Aktuell: <?php echo $_SESSION['edit-product']['cat'] ?>)</label><br />
          <select id="category" name="category">
            <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['id'] ?>"><?php echo $category['category'] ?>
            </option>
            <?php endforeach ?>
          </select>
          <br />
          <label for="quantity">Stück</label>
          <input id="quantity" type="number" name="quantity" value="<?php echo $_SESSION['edit-product']['quantity'] ?>"><br /><br />
          <label for="">Preis (in cent)</label>
          <input type="number" name="price" value="<?php echo $_SESSION['edit-product']['price'] ?>">
          <input type="hidden" name="productId" value="<?php echo $_SESSION['edit-product']['id'] ?>">
          <input type="hidden" name="productStatus" value="<?php echo $_SESSION['edit-product']['status'] ?>">
          <div class="space-small"></div>
          <input class="button" type="submit" value="Speichern">
          <button class="button-cancel pos-right"><a href="/views/products.php">Abbrechen</a></button>
        </form>
      </div>
      <div class="col-3"></div>
    </div>

    <div class="space-big"></div>
  </div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>