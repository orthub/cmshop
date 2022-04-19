<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/userList.php';
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

    <table>
      <thead>
        <tr>
          <th>Vorname</th>
          <th>Email</th>
          <th>Rechte</th>
          <th>Neue Rechte</th>
          <th>Löschen</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($all_users as $user) : ?>
        <tr>
          <td><?php echo $user['first_name'] ?></td>
          <td><?php echo $user['email'] ?></td>
          <td><?php echo $user['role'] ?></td>
          <td>
            <form action="/controllers/new-role.php" method="POST">
              <select class="mt-10" name="user-rights" id="userRights">
                <?php foreach ($roles as $role) : ?>
                <option value="<?php echo $role['id'] ?>"><?php echo $role['role'] ?></option>
                <?php endforeach ?>
                <input type="hidden" name="userId" value="<?php echo $user['id'] ?>">
                <input class="button" type="submit" value="Aktualisieren">
            </form>
          </td>
          <td>
            <form action="/controllers/delete-user.php" method="POST">
              <input type="hidden" name="remove-user" value="<?php echo $user['id'] ?>">
              <input class="button-delete" type="submit" value="Löschen">
            </form>
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