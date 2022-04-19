<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/userRights.php';


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];

  if ($role === 'CUSTOMER') {
    header('Location: ' . '/');
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    require_once __DIR__ . '/../helpers/session.php';
    $product_title = trim(filter_input(INPUT_POST, 'product', FILTER_SANITIZE_SPECIAL_CHARS));
    $slug = trim(filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS));
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS));
    $price = trim(filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT));
    $category_id = trim(filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS));
    $quantity = trim(filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT));

    if ((bool)$product_title === false) {
      $_SESSION['error']['title'] = 'Titel darf nicht leer sein';
      $errors[] = 1;
    }
    if ((bool)$slug === false) {
      $_SESSION['error']['slug'] = 'Slug darf nicht leer sein';
      $errors[] = 1;
    }
    if ((bool)$description === false) {
      $_SESSION['error']['description'] = 'Bitte eine Beschreibung für das Produkt eingeben';
      $errors[] = 1;
    }
    if ((bool)$price === false) {
      $_SESSION['error']['price'] = 'Preis darf nicht leer sein';
      $errors[] = 1;
    }
    if ((bool)$quantity === false) {
      $_SESSION['error']['quantity'] = 'Stückzahl wird benötigt';
      $errors[] = 1;
    }
    
    if (count($errors) > 0 ) {
      header('Location: ' . '/views/newProduct.php');
    }

    if ((bool)$product_title) {
      $_SESSION['newProduct']['title'] = $product_title;
    }
    if ((bool)$slug) {
      $_SESSION['newProduct']['slug'] = $slug;
    }
    if ((bool)$description) {
      $_SESSION['newProduct']['description'] = $description;
    }
    if ((bool)$price) {
      $_SESSION['newProduct']['price'] = $price;
    }
    if ((bool)$category) {
      $_SESSION['newProduct']['category'] = $category_id;
    }
    if ((bool)$quantity) {
      $_SESSION['newProduct']['quantity'] = $quantity;
    }

    if (count($errors) === 0) {
      require_once __DIR__ . '/../models/products.php';
      $categories = get_categories();

      $slug_exists = check_slugs($slug);
    
      if ($slug_exists === $slug){
        $_SESSION['error']['slug-exists'] = 'Slug wird schon verwendet, bitte einen neuen wählen';
        header('Location: ' . '/views/newProduct.php');
        exit();
      }
    }

    $product_image_path = '/var/www/html/img/products/' . $slug . '/';

    if (mkdir($product_image_path, 0700) === false) {
      $_SESSION['error']['no-path'] = 'Pfad nicht erstellt';
      header('Location: ' . '/views/newProduct.php');
      exit();
    }
    
    $create_new_product = new_product($product_title, $slug, $description, $price, $category_id, $quantity);

    if ($create_new_product){
      $_SESSION['new-product'] = 'Neues Produkt erfolgreich angelegt';
      unset($_SESSION['newProduct']);
      unset($_SESSION['error']);
      header('Location: ' . '/views/products.php');
    } 
  }
}