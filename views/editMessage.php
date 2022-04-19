<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/editMessage.php';
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
        <a href="/views/message-list.php">Zurück zur Übersicht</a>
        <div class="space-mid"></div>
        <h2><?php echo $_SESSION['edit-message']['title'] ?></h2>
        <br />
        <p><?php echo $_SESSION['edit-message']['message'] ?></p>
        <br />
        <hr />
        <table class="no-table-style">
          <tr class="no-table-style">
            <td class="no-table-style">Status: <?php echo $_SESSION['edit-message']['status'] ?></td>
            <td></td>
            <td class="no-table-style">
              <form action="/controllers/newMessageStatus.php" method="POST">
                <select class="mt-10" name="message-status" id="messageStatus">
                  <?php foreach ($_SESSION['edit-message']['edit-status'] as $newStatus) : ?>
                  <option value="<?php echo $newStatus['id'] ?>"><?php echo $newStatus['status'] ?></option>
                  <?php endforeach ?>
                </select>
                <input type="hidden" name="message-id" value="<?php echo $_SESSION['edit-message']['message_id'] ?>">
                <input class="button" type="submit" value="Aktualisieren">
              </form>
            </td>
            <td></td>
            <td>
              <?php if ($role === 'ADMIN') : ?>
              <form action="/controllers/deleteMessage.php" method="POST">
                <input type="hidden" name="delete-message" value="<?php echo $_SESSION['edit-message']['message_id'] ?>">
                <input class="button-delete" type="submit" value="Löschen">
              </form>
              <?php endif ?>
            </td>
          </tr>
        </table>
        <hr />
        <br />
        <p><?php echo 'Vom: ' . $_SESSION['edit-message']['created'] ?></p>
        <p><?php echo 'Email: ' .  $_SESSION['edit-message']['email'] ?></p>
      </div>
      <div class="col-2"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>