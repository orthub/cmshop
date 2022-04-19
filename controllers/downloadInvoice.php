<?php
namespace Dompdf;
require_once __DIR__ . '/../helpers/session.php';

require_once __DIR__ . '/../helpers/nonUserRedirect.php';

use Dompdf\Dompdf;

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['base-order']['orders_id'];

$root_path = $_SERVER['DOCUMENT_ROOT'];
$file = '/storage/' . $user_id . '/Rechnung_' . $order_id . '.pdf';
$file_path = $root_path . $file;


if (file_exists($file_path)) {
  //Define header information
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename="' . basename("Rechnung_" . $file) . '"');
  header('Content-Length: ' . filesize($file_path));
  header('Pragma: public');

  //Clear system output buffer
  flush();

  //Read the size of the file
  readfile($file_path);

  exit();
}

if (!file_exists($file_path)) {
  require_once __DIR__ . '/../lib/vendor/autoload.php';
  require_once __DIR__ . '/../lib/vendor/dompdf/dompdf/src/Autoloader.php';
  require_once __DIR__ . '/../models/invoice.php';
  $render_table_products = '';
  
  $get_base_order = get_order_with_user_and_order_id($user_id, $order_id);
  $get_products_from_order = get_products_for_order($order_id);

  $_SESSION['order-products-quantity'] = $get_products_from_order;

  $counting = count($get_products_from_order) - 1;

  $products = [];
  for ($count = 0; $count <= $counting; $count++) {
    $productInfo[] = get_product_order_info($get_products_from_order[$count]['product_id']);
    $products[$count]['quantity'] = $get_products_from_order[$count]['quantity'];
  }

  $_SESSION['products-from-order'] = $productInfo;
  $_SESSION['base-order'] = $get_base_order;


  // instantiate and use the dompdf class
  $dompdf = new Dompdf();
  $end_price = 0;

  // produkte für tabelle generieren + gesamtpreis
  foreach ($_SESSION['products-from-order'] as $product) {
    $render_table_products .= 
    '<tr>
      <td class="text-left">' . $product['title'] . '</td>
      <td class="text-left">' . $product['quantity'] . '</td>
      <td class="text-left">' . $product['price'] / 100 . '€</td> 
    </tr>';
    $price = $product['price'] * $product['quantity'];
    $end_price = $end_price + $price;
  } // FEHLER BEIM PREIS


  // HTML für die Erstellung des PDF-Dokuments
  $render_to_html ='
  <html>
  <head>
  <style>
  html, body {margin: 0;padding:0}
  body {height: 100%;}
  table {}
  h1 {font-size: 32px}
      h2 {font-size: 24px}
      p {font-size: 16px}
      th, td {padding: 6px 10px}
      .content {margin: 2cm 1.5cm 1.5cm 2cm;}
      .text-left {text-align: left;}
      .text-center {text-align: center}
      .text-right {text-align: right}
      .float-left {float:left;}
      .footer {position:absolute; width:100%; bottom: 190px;}
    </style>
  </head>
  <body>
    <div class="content">
      <h1>Rechnung:</h1>
      <hr />
      <p>Bestell Nummer: <b>' . $_SESSION["base-order"]["orders_id"] . '</b></p>
      <p>Bestell Datum: <b>' . $_SESSION['base-order']['order_date'] . '</b></p>
      <p>Bestell Status: <b>' .  $_SESSION['base-order']['status'] . '</b></p>
      <hr />
      <h2>Produkte:</h2>
      <table>
      <thead>
      <tr>
      <th class="text-left">Produkt</th>
      <th class="text-left">Stück</th>
            <th class="text-left">Preis</th>
          </tr>
        </thead>
        <tbody>
        ' . $render_table_products . '
        </tbody>
        </table>
        <div class="text-right">
          <p>Gesamtpreis:(inkl. MwSt)</p>
          <p>' . $_SESSION["base-order"]["order_price"]. '€</p>
        <div>
        <p class="text-left">Bitte berücksichtigen sie, dass die Versendung der Waren erst nach eingelangter Zahlung auf unser Konto erfolgt.</p>
        <p class="text-left">Benutzen sie für die Überweisung als Verwendungszweck: ' .$_SESSION["base-order"]["orders_id"] . '</p>
      <div class="footer">
        <hr />
        <div class="text-center">
          <p>Firma Stiftl GmbH</p>
          <p>Stiftlstraße 1</p>
          <p>1299 Stiftlingen</p>
        <div>
        </div>
        </div>
        </body>
  </html>
  ';

  $dompdf->loadHtml($render_to_html);

  // (Optional) Setup the paper size and orientation
  $dompdf->setPaper('A4', 'portrait');

  // Render the HTML as PDF
  $dompdf->render();

  $output = $dompdf->output();

  file_put_contents('../storage/' . $user_id . '/Rechnung_' . $order_id . '.pdf', $output);
  
  //Clear system output buffer
  flush();
  
}