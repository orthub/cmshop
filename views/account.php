<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../controllers/products.php';
require_once __DIR__ . '/../controllers/getDeliveryAddress.php';
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
    <h2 class="text-center">Account</h2>
    <div class="space-small"></div>

    <div class="row">
      <div class="col-6">
        <p class="text-bold">Neue Lieferadresse hinzufügen</p><br />
        <form action="/controllers/accountNewAddress.php" method="POST">
          <label for="street">Straße:</label><br />
          <input type="text" name="street" id="street" value="<?php echo (isset($_SESSION['address']['street'])) ? $_SESSION['address']['street'] : '' ?>" />
          <br /><br />
          <label for="streetNumber">Straßennummer:</label><br />
          <input type="text" name="streetNumber" id="streetNumber" value="<?php echo (isset($_SESSION['address']['streetNumber'])) ? $_SESSION['address']['streetNumber'] : '' ?>" /><br /><br />
          <label for="city">Stadt:</label><br />
          <input type="text" name="city" id="city" value="<?php echo (isset($_SESSION['address']['city'])) ? $_SESSION['address']['city'] : '' ?>" /><br /><br />
          <label for="zip">Postleitzahl:</label><br />
          <input type="text" name="zip" id="text" value="<?php echo (isset($_SESSION['address']['zip'])) ? $_SESSION['address']['zip'] : '' ?>" /><br /><br />
          <input class="button" type="submit" value="Lieferadresse hinzufügen" />
        </form>
      </div>
      <div class="col-6">
        <p class="text-bold">Passwort ändern</p><br />
        <form action="/controllers/accountPWchange.php" method="POST">
          <label for="accountPWcurrent">Aktuelles Passwort</label><br />
          <input id="accountPWcurrent" name="current-pw" type="password" value="<?php echo (isset($_SESSION['account']['cur-pw'])) ? $_SESSION['account']['cur-pw'] : '' ?>"><br /><br />
          <label for="accountPWnew">Neues Passwort</label><br />
          <input id="accountPWnew" name="new-pw" type="password" value="<?php echo (isset($_SESSION['account']['new-pw'])) ? $_SESSION['account']['new-pw'] : '' ?>"><br /><br />
          <label for="accountPWconfirm">Passwort bestätigen</label><br />
          <input id="accountPWconfirm" name="confirm-pw" type="password" value="<?php echo (isset($_SESSION['account']['conf-pw'])) ? $_SESSION['account']['conf-pw'] : '' ?>"><br /><br />
          <input class="button" type="submit" value="Passwort ändern">
        </form>
      </div>
    </div>

    <div class="space-big"></div>
    <p class="text-bold">Verfügbare Lieferadressen</p>

    <div class="row">
      <?php foreach ($deliveryAddress as $key => $value) : ?>
      <div class="col-2">
        <div class="delivery-address">
          <form action="/controllers/accountDeleteAddress.php" method="POST">
            <?php echo $value['city'] . '<br />';
                echo $value['zip_code'] . '<br />';
                echo $value['street'] . ' / ' . $value['street_number'] . '<br />';?>
            <input type="hidden" value="<?php echo $value['id'] ?>" name="delete-address" />
            <input class="button-delete" type='submit' value='Adresse löschen' />
          </form>
        </div>
      </div>
      <?php endforeach ?>
    </div>

    <div class="space-small"></div>

    <div class="row">
      <div class="col-3"></div>
      <div class="col-6 text-center">
        <form action="/views/accountDeleteConfirm.php" method="POST">
          <input class="button-delete" type="submit" value="Konto löschen">
        </form>
      </div>
      <div class="col-3"></div>
    </div>

  </div>
  <div class="space-big"></div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>