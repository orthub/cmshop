<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];

  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
  }

  require_once __DIR__ . '/../models/products.php';

  $slug = $_SESSION['edit-product']['slug'];

  $upload_folder = '/var/www/html/img/products/' . $slug . '/';
  $filename = pathinfo($_FILES['product-image']['name'], PATHINFO_FILENAME);
  $extension = strtolower(pathinfo($_FILES['product-image']['name'], PATHINFO_EXTENSION));
  $allowed_extensions = array('png', 'jpg', 'jpeg');
  
  // prüfen auf die erlaubten dateiendungen
  if (!in_array($extension, $allowed_extensions)) {
    $_SESSION['error']['image-type'] = 'Nur .png, .jpg und .jpeg sind erlaubt';
    header('Location: ' . '/views/editProduct.php');
  }

  // TODO
  // limit für uploadgröße prüfen maximal 500kb
  // $max_filesize = 700 * 1024;
  // if ($_FILES['product-image']['size'] > $max_filesize) {
  //   $_SESSION['error']['image-size'] = 'Das gewählte Bild ist zu groß. Maximal 500kb';
  //   header('Location: ' . '/views/editProduct.php');
  // }
  
  $upload_image = $upload_folder . $slug . '.' . $extension;
  
  $upload_file = move_uploaded_file($_FILES['product-image']['tmp_name'], $upload_image);
  
  if ($upload_file === false) {
    $_SESSION['error']['upload-failed'] = 'Datei konnte nicht hochgeladen werden';
    header('Location: ' . '/views/editProduct.php');
    exit();
  }

  $image_url_for_database = '/img/products/' . $slug . '/' . $slug . '.' . $extension;

  $update_image = update_product_image_by_slug($image_url_for_database, $slug);

  if ($update_image === false) {
    $_SESSION['error']['update-failed'] = 'Dateipfad konnte nicht in der Datenbank gespeichert werden';
    header('Location: ' . '/views/editProduct.php');
    exit();
  }

  if ($update_image) {
    $_SESSION['edit-product']['img_url'] = $image_url_for_database;
    unset($_SESSION['error']);
    header('Location: ' . '/views/editProduct.php');
    exit();
  }

}