<?php require_once __DIR__ . '/../helpers/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="content">
    <div class="space-mid"></div>
    <div class="text-center">
      <?php require_once __DIR__ . '/../helpers/flashMessage.php' ?>
    </div>
    <div class="space-small"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <h1><a name="reg_anker">Registrieren</a></h1>
        <div class="space-small"></div>
        <form action="/controllers/register.php" method="POST">
          <label for="first_name">Vorname</label><br />
          <input id="first_name" type="text" name="first_name" value="<?php echo (isset($_SESSION['registerFirstname'])) ? $_SESSION['registerFirstname'] : ''?>"><br /><br />
          <label for="last_name">Nachname</label><br />
          <input id="last_name" type="text" name="last_name" value="<?php echo (isset($_SESSION['registerLastname'])) ? $_SESSION['registerLastname'] : ''?>"><br /><br />
          <label for="email">Email</label><br />
          <input id="email" type="email" name="email" value="<?php echo (isset($_SESSION['registerEmail'])) ? $_SESSION['registerEmail'] : ''?>"><br /><br />
          <label for="passwd">Passwort</label><br />
          <input id="passwd" type="password" name="passwd" value="<?php echo (isset($_SESSION['registerPassword'])) ? $_SESSION['registerPassword'] : ''?>"><br /><br />
          <label for="confirm_passwd">Passwort wiederholen</label><br />
          <input id="confirm_passwd" type="password" name="confirm_passwd"><br /><br />
          <input class="button" type="submit" value="Registrieren">
        </form>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>