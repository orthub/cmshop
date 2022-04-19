<?php
require_once __DIR__ . '/../helpers/session.php';
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

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <div class="text-center">
          <h2>Danke für Ihre Registrierung</h2>
          <br />
          <p>Sie erhalten in kürze eine Bestätigungsmail mit einem aktivierungs link.</p>
        </div>
      </div>
      <div class="col-2"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>