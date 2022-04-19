<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/messageList.php';
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
      <div class="col-1"></div>
      <div class="col-9">
        <?php if (count($all_messages) === 0) : ?>
        <h2 class="text-center">Keine Nachrichten vorhanden</h2>
        <?php endif ?>
        <?php if (count($all_messages) > 0) : ?>
        <table>
          <thead>
            <tr>
              <th>Titel</th>
              <th>Nachricht</th>
              <th>Gesendet</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_messages as $message) : ?>
            <tr>
              <td><?php echo $message['title'] ?></td>
              <td><?php echo $message['message'] ?></td>
              <td><?php echo $message['created'] ?></td>
              <td><?php echo $message['status'] ?></td>
              <td>
                <form action="/controllers/editMessage.php" method="POST">
                  <input type="hidden" name="message-id" value="<?php echo $message['message_id'] ?>">
                  <input class="button" type="submit" value="Bearbeiten">
                </form>
              </td>
              <td>
                <?php if ($role === 'ADMIN') : ?>
                <form action="/controllers/deleteMessage.php" method="POST">
                  <input type="hidden" name="delete-message" value="<?php echo $message['message_id'] ?>">
                  <input class="button-delete" type="submit" value="Löschen">
                </form>
                <?php endif ?>
              </td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
        <?php endif ?>
      </div>
      <div class="col-1"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>