<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../controllers/products.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
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
    <h2 class="text-center">Bestätigen sie die Löschanfrage</h2>
    <div class="space-mid"></div>
    <p class="text-center">Wenn sie ihr Konto löschen, werden sie vom System ausgeloggt und auf unsere Startseite umgeleitet</p>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6 text-center">
        <form action="/controllers/accountDelete.php" method="POST">
          <input class="button-delete" type="submit" value="Konto löschen">
        </form>
        <div class="space-small"></div>
        <button class="button"><a href="/views/account.php">Abbrechen</a></button>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>