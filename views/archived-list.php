<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/archivedList.php';
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
    <a href="/views/dashboard.php">Zurück</a>
    <div class="space-small"></div>

    <table>
      <thead>
        <tr>
          <th>Vorname</th>
          <th>Nachname</th>
          <th>Email</th>
          <th>Rechte</th>
          <th>Rechnungen</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($archived_users as $user) : ?>
        <tr>
          <td><?php echo $user['first_name'] ?></td>
          <td><?php echo $user['last_name'] ?></td>
          <td><?php echo $user['email'] ?></td>
          <td><?php echo $user['role'] ?></td>
          <td>
            <?php if (isset($user['invoice_path']) > 0) : ?>
            <form action="/controllers/archivedInvoices.php" method="POST">
              <input type="hidden" name="archived-invoices" value="<?php echo $user['id'] ?>">
              <input class="button" type="submit" value="Rechnungen ansehen">
            </form>
            <?php endif ?>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>

  </div>
  <div class="space-big"></div>
  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>