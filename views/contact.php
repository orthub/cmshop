<?php 
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../controllers/contactForUsers.php';
require_once __DIR__ . '/../controllers/contactSpam.php';
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
        <div class="space-small"></div>
        <h1>Kontaktformular</h1>
        <div class="space-small"></div>
        <p>Wenn Sie irgendwelche Anliegen haben, zögern Sie nicht und Kontaktieren Sie uns.</p>
        <div class="space-small"></div>
        <form action="/controllers/contact.php" method="POST">
          <label for="email">Email:</label><br />
          <?php if (!isset($_SESSION['user_id'])) : ?>
          <input id="email" type="email" name="contact-email" value="<?php echo (isset($_SESSION['contact']['email'])) ? $_SESSION['contact']['email'] : '' ?>" /><br /><br />
          <label for="title">Titel:</label><br />
          <?php endif ?>
          <?php if (isset($_SESSION['user_id'])) : ?>
          <input id="email" type="email" name="contact-email" value="<?php echo (isset($_SESSION['contact']['user-email'])) ? $_SESSION['contact']['user-email'] : '' ?>" /><br /><br />
          <label for="title">Titel:</label><br />
          <?php endif ?>
          <input id="title" type="text" name="contact-title" value="<?php echo (isset($_SESSION['contact']['title'])) ? $_SESSION['contact']['title'] : '' ?>" /><br /><br />
          <label for="message">Nachricht:</label><br />
          <textarea id="message" name="contact-message"><?php echo (isset($_SESSION['contact']['message'])) ? $_SESSION['contact']['message'] : '' ?></textarea><br /><br />
          <label for="contact-spam">Lösen Sie bitte folgende Rechnung:
          </label><?php echo $spam_protect ?>
          <input id="contact-spam" type="text" name="contact-spam"><br /><br />
          <input class="button" type="submit" value="Abschicken" />
        </form>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>