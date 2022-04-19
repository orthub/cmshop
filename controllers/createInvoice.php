<?php
namespace Dompdf;
require_once __DIR__ . '/../helpers/session.php';
require_once __DIR__ . '/../helpers/nonUserRedirect.php';

use Dompdf\Dompdf;

$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['order_id'];

$root_path = $_SERVER['DOCUMENT_ROOT'];
$file = '/storage/' . $user_id . '/Rechnung_' . $order_id . '.pdf';
$file_path = $root_path . $file;

if (file_exists($file_path)) {
  $date = date('d.m.Y H.i');
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
  require_once __DIR__ . '/../config/company_data.php';
  $render_table_products = '';
  
  $get_base_order = get_order_with_user_and_order_id($user_id, $order_id);
  $get_products_from_order = get_products_for_order($order_id);
  $delivery_address = get_delivery_address_for_order($user_id, $get_base_order['delivery_address_id']);
  $user_data = get_user_data_by_id($user_id);

  $_SESSION['order-products-quantity'] = $get_products_from_order;

  $counting = count($get_products_from_order) - 1;

  $products = [];
  for ($count = 0; $count <= $counting; $count++) {
    $products[] = get_product_order_info($get_products_from_order[$count]['product_id']);
    $products[$count]['quantity'] = $get_products_from_order[$count]['quantity'];
  }
  
  $_SESSION['base-order'] = $get_base_order;
  (int)$priceWithoutDeliveryCosts = (int)$_SESSION["base-order"]["order_price"] - (int)DELIVERY_COSTS / 100;

  // instantiate and use the dompdf class
  // $dompdf = new Dompdf();
  $dompdf = new Dompdf(["chroot" => ["/var/www/html/img/comp"]]);
  $endprice = 0;

  $position = 1;
  // produkte für tabelle generieren + gesamtpreis
  foreach ($products as $product) {
    $render_table_products .= 
    '<tr>
      <td class="product-table text-left">' . $position . '</td>
      <td class="product-table text-left">' . $product['title'] . '</td>
      <td class="product-table text-center">' . $product['quantity'] . '</td>
      <td class="product-table text-center">(' . COMPANY_VAT . ' %)</td>
      <td class="product-table text-left">' . $product['price'] / 100 . ' EUR</td>
      <td class="product-table text-right">' . ($product['price'] * $product['quantity']) . ' EUR</td>
    </tr>';
    $price = $product['price'] * $product['quantity'];
    $end_price = $end_price + $price;
    $position++;
  }

  $without_vat = round($end_price / 1.20);
  $vat = $end_price - $without_vat;

  // HTML für die Erstellung des PDF-Dokuments
  $render_to_html ='
  <html>
  
  <head>
  <style>
    html, body {margin: 0;padding:0}
    body {height: 100%;}
    table, td, th {border-collapse:collapse}
    th {border-top:1px solid black;border-bottom:1px solid black}
    .product-table {border-bottom:1px solid black}
    h1 {font-size: 20px}
    h2 {font-size: 18px}
    p {font-size: 16px}
    .company {float:left;width:32%}
    .company:last-child {margin-right:0}
    .logo {max-width:160px}
    th, td {padding: 6px 10px}
    .content {margin: 2cm 1.5cm 1.5cm 2cm;}
    .text-left {text-align: left;}
    .text-center {text-align: center}
    .text-right {text-align: right}
    .float-left {float:left;}
    .clearing {clear:both}
    .no-mar-pad {margin:0;padding:0}
  </style>
  </head>
  
  <body>
    <div class="content">
    <div class="company">
      <img class="logo" src="/var/www/html/img/comp/logo.png" />
    </div>
    <div class="company">
      <p class="no-mar-pad">' . COMPANY_NAME . '</p>
      <p class="no-mar-pad">' . COMPANY_STREET . '</p>
      <p class="no-mar-pad">' . COMPANY_ZIP . ' ' . COMPANY_CITY . '</p>
    </div>
    <div class="company">
      <p class="no-mar-pad">Tel: ' . COMPANY_PHONE . '</p>    
      <p class="no-mar-pad">E-Mail: ' . COMPANY_MAIL . '</p>    
      <p class="no-mar-pad">Web: ' . COMPANY_WEB . '</p>    
    </div>
    <div class="clearing"></div>
      <p class="no-mar-pad"><b>Rechnungsanschrift:</b></p><br />
      <p class="no-mar-pad">' . $user_data['first_name'] .' ' . $user_data['last_name'] . '</p>
      <p class="no-mar-pad">' . $delivery_address['street'] .' / ' . $delivery_address['street_number'] . '</p>
      <p class="no-mar-pad">' . $delivery_address['zip_code'] . ' '. $delivery_address['city'] . '</p>
      <p class="text-right"><b>' . date("d.m.Y") . '</b></p>
      <p><b>Rechnungs Nummer: ' . $_SESSION["base-order"]["orders_id"] . '</b></p>
      <br />
      <p class="no-mar-pad"><b>Guten Tag,</b></p>
      <p class="no-mar-pad">gemäß Ihrer Bestellung berechnen wir folgenden Auftrag:</p>
      <h2>Bestellung:</h2>
      <table>
        <thead>
          <tr>
            <th class="text-left">Pos.</th>
            <th class="text-left">Artikel</th>
            <th class="text-left">Anzahl</th>
            <th class="text-center">MwSt-Satz</th>
            <th class="text-left">Einzelpreis</th>
            <th class="text-right">Preis</th>
            </tr>
        </thead>
        <tbody>
        ' . $render_table_products . '
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class=" text-right">Gesamt: ' . $end_price / 100 . ' EUR</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Versandkosten: ' . DELIVERY_COSTS / 100 . ' EUR</td>
          </tr>
          <tr>
          <td></td>
          <td><small>Zahlart:</small></td>
            <td><small>Vorkasse</small></td>
            <td></td>
            <td></td>
            <td class="text-right"><b>Gesamt-Brutto: ' . $_SESSION["base-order"]["order_price"] / 100 . ' EUR</b></td>
          </tr>
          <tr>
          <td></td>
          <td><small>Versandart:</small></td>
          <td><small>Standard Post</small></td>
          <td></td>
          <td></td>
          <td class="text-right">Gesamt ohne MwSt: ' . $without_vat / 100 . ' EUR</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right">MwSt: ' . $vat / 100 . ' EUR</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td class="text-right">MwSt Betrag: 20% ' . $vat / 100 . ' EUR</td>
        </tr>
        </tbody>
      </table>
      <p class="text-left">Bitte berücksichtigen sie, dass die Versendung der Waren erst nach eingelangter Zahlung auf unser Konto erfolgt.</p>
      <p class="text-left">Benutzen sie für die Überweisung als Verwendungszweck: ' .$_SESSION["base-order"]["orders_id"] . '</p>
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