<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/archivedInvoices.php';
?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>

  <div class="space-mid"></div>
  <div class="content">

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
        <div class="space-small"></div>
        <a href="/views/archived-list.php">Zurück</a>
        <br />
        <div class="space-small"></div>
        <?php foreach ($_SESSION['archived']['invoice'] as $invoice) : ?>
        <a href="<?php echo $_SESSION['archived']['invoice-url'] . $invoice ?>"><?php echo $invoice ?></a><br />
        <?php endforeach ?>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>