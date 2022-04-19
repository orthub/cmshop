<?php require_once __DIR__ . '/../helpers/session.php'; ?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <div class="content">
    <div class="space-mid"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6">
        <?php require_once __DIR__ . '/../helpers/flashLogin.php' ?>
        <div class="space-small"></div>
        <h1>Login</h1>
        <div class="space-small"></div>
        <div class="login-form">
          <form action="/controllers/login.php" method="POST">
            <label for="email-login">Email:</label><br />
            <input type="email" name="email" id="email-login" value="<?php echo (isset($_SESSION['loginEmail'])) ? $_SESSION['loginEmail'] : ''?>" /><br /><br />
            <label for="pass-login">Passwort:</label><br />
            <input type="password" name="passwd" id="pass-login" value="<?php echo (isset($_SESSION['loginPasswd'])) ? $_SESSION['loginPasswd'] : ''?>" /><br /><br />
            <input class="button" type="submit" value="Login" />
          </form>
        </div>
        <br />
        <a href="/views/register.php">Keinen Account? Hier gehts zur Registrierung</a>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>