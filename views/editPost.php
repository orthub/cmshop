<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';
require_once __DIR__ . '/../controllers/editPost.php';
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
      <div class="col-4"></div>
      <div class="col-4">
        <a href="/controllers/postStatus.php?postid=<?php echo $_SESSION['edit-post']['id'] . '&status=' . $_SESSION['edit-post']['published'] ?>">
          <button class="<?php echo ($_SESSION['edit-post']['published'] === 'LIVE') ? 'button-live' : 'button-draft' ?>">Veröffentlicht: <?php echo ($_SESSION['edit-post']['published'] === 'LIVE') ? 'Ja' : 'Nein' ?></button>
        </a>
        <br /><br />
        <form action="/controllers/editPostSave.php" method="POST">
          <label for="post-title">Titel</label>
          <input id="post-title" type="text" name="title" value="<?php echo $_SESSION['edit-post']['title'] ?>" />
          <label for="post-body">Beschreibung</label>
          <textarea id="post-body" name="body"><?php echo $_SESSION['edit-post']['body'] ?></textarea>
          <input type="hidden" name="postId" value="<?php echo $_SESSION['edit-post']['id'] ?>" />
          <input type="hidden" name="postStatus" value="<?php echo $_SESSION['edit-post']['published'] ?>" />
          <input class="button" type="submit" value="Speichern" />
        </form>
      </div>
      <div class="col-4"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>