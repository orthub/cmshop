<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <?php require_once __DIR__ . '/../controllers/newProduct.php' ?>
  <div class="content">
    <div class="space-mid"></div>
    <div class="text-center">
      <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
    </div>
    <div class="space-small"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <form action="/controllers/newProduct.php" method="POST">
          <label for="product">Produktname</label><br />
          <input onkeyup="slug_generator()" type="text" name="product" id="product" value="<?php echo (isset($_SESSION['newProduct']['title'])) ? $_SESSION['newProduct']['title'] : '' ?>" /><br /><br />
          <label for="slug">Slug</label><br />
          <input type="text" id="slug" name="slug" value="<?php echo (isset($_SESSION['newProduct']['slug'])) ? $_SESSION['newProduct']['slug'] : '' ?>"></input><br /><br />
          <label for="description">Beschreibung</label><br />
          <textarea id="description" name="description"><?php echo (isset($_SESSION['newProduct']['description'])) ? $_SESSION['newProduct']['description'] : '' ?></textarea><br /><br />
          <label for="price">Preis (in cent)</label><br />
          <input type="number" id="price" name="price" value="<?php echo (isset($_SESSION['newProduct']['price'])) ? $_SESSION['newProduct']['price'] : '' ?>"></input><br /><br />
          <label for="category">Kategorie</label><br />
          <select id="category" name="category">
            <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['id'] ?>"><?php echo $category['category'] ?></option>
            <?php endforeach ?>
          </select>
          <br />
          <label for="quantity">Stückzahl</label><br />
          <input type="number" id="quantity" name="quantity" value="<?php echo (isset($_SESSION['newProduct']['quantity'])) ? $_SESSION['newProduct']['quantity'] : '' ?>"></input><br /><br />
          <input class="button" type="submit" value="Speichern"></input>
          <button class="button-cancel pos-right"><a href="/views/products.php">Abbrechen</a></button>
        </form>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

<script src="/js/slug-generator.js"></script>

</html>