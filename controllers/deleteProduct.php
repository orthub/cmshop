<?php
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/userRights.php';
require_once __DIR__ . '/../models/products.php';
require_once __DIR__ . '/../models/userRights.php';


if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_role = check_user_role($user_id);
  $role = $user_role['role'];
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $role === 'ADMIN') {
    require_once __DIR__ . '/../helpers/session.php';
    $product_id = htmlspecialchars($_POST['delete-product']);
    
    // pfad und slug aus der datenbank holen
    $image_slug_url = get_slug_path_by_id($product_id);
    $path_to_file = '/var/www/html' . $image_slug_url['img_url'];
  
    // aus der datenbank löschen, falls das produkt nicht schon verwendet wurde
    $delete_from_database = delete_product_by_id($product_id);
    
    if ($delete_from_database === false) {
      $_SESSION['error']['constraint'] = 'Produkt wird verwendet und kann nicht gelöscht werden';
      header('Location: ' . '/views/product-list.php');
      exit();
    }

    // wenn die datei existiert und nicht das standardbild verwendet wird, wird die datei gelöscht
    if (file_exists($path_to_file) && $path_to_file !== '/var/www/html/img/products/default.jpg') {
      $delete_file = unlink($path_to_file);
      
      if ($delete_file === false) {
        $_SESSION['error']['product-exist'] = 'Produkt nicht vom Datenträger gelöscht';
        header('Location: ' . '/views/product-list.php');
        exit();
      }
    }

    // pause um sicher zu stellen, dass das verzeichnis leer ist
    sleep(1);
 
    // prüfen ob der ordner vorhanden ist, wenn nein wird eine warnung angezeigt und weiter gemacht
    if (!file_exists('/var/www/html/img/products/' . $image_slug_url['slug'])) {
      $_SESSION['warning']['folder-didnt-exist'] = 'Ordner existierte nicht mehr beim löschen';
      $delete_folder = true;
    }

    // prüfen ob der ordner vorhanden ist
    if (file_exists('/var/www/html/img/products/' . $image_slug_url['slug'])) {
      // ordner löschen
      $delete_folder = rmdir('/var/www/html/img/products/' . $image_slug_url['slug']);
      // fehler beim löschen des ordners
      if ($delete_folder === false) {
        $_SESSION['error']['folder-exist'] = 'Fehler beim löschen des Verzeichnisses';
        header('Location: ' . '/views/product-list.php');
        exit();
      }
    }

    // wenn datei in der datenbank gelöscht wurde und der ordner, wird eine erfolgsmeldung ausgegeben
    if ($delete_from_database && $delete_folder) {
      $_SESSION['success']['product-deleted'] = 'Produkt wurde erfolgreich gelöscht';
      header('Location: ' . '/views/product-list.php');
      exit();
    }

  }

}