<?php require_once __DIR__ . '/../helpers/session.php'; ?>
<!DOCTYPE html>
<html>
<?php require_once __DIR__ . '/partials/head.php' ?>
<?php $post_id = htmlspecialchars($_GET['post_id']) ?>

<body>
  <?php require_once __DIR__ . '/partials/navbar.php' ?>
  <?php require_once __DIR__ . '/partials/userbar.php' ?>
  <?php require_once __DIR__ . '/../controllers/posts.php' ?>
  <?php $single_post = get_post_by_id($post_id) ?>
  <div class="content">
    <div class="space-mid"></div>

    <div class="row">
      <div class="col-2"></div>
      <div class="col-8">
        <h2><?php echo $single_post['title'] ?></h2>
        <br />
        <p><?php echo $single_post['body'] ?></p>
        <br />
        <hr />
        <small><?php echo $single_post['first_name'] . ' | ' . $single_post['created'] ?></small>
        <br />
        <br />
        <a href="/views/posts.php"><button class="button">Zurück</button></a>
      </div>
      <div class="col-2"></div>
    </div>

  </div>
  <div class="space-big"></div>

  <?php require_once __DIR__ . '/partials/footer.php' ?>
</body>

</html>