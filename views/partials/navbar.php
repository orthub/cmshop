<?php
require_once __DIR__ . '/../../config/company_data.php';
require_once __DIR__ . '/../../models/cart.php';
require_once __DIR__ . '/../../controllers/products.php';
require_once __DIR__ . '/../../controllers/userRights.php';
$cartItemsCount = null;
if (isset($_SESSION['user_id'])) {
  $cartItemsCount = count_products_for_user($_SESSION['user_id']);
} ?>

<navbar>
  <div class="comp-logo">
    <a href="/index.php"><img src="/img/comp/logo.png" alt="Company Logo"></a>
  </div>

  <input class="check-btn-nav" type="checkbox" id="toggle-btn">
  <label for="toggle-btn" class="show-menu-btn"><i class="fas fa-bars"></i></label>

  <nav>
    <ul class="navigation">
      <li><a href="/index.php"><i class="fas fa-house-damage"></i><?php echo ' ' . COMPANY_NAME ?></a></li>
      <li><a href="/views/posts.php"><i class="fab fa-blogger-b"></i> Neues</a></li>
      <li><a href="/views/products.php"><i class="fas fa-store"></i> Shop</a></li>
      <div class="dropdown">
        <li><a href="/views/products.php"><i class="fas fa-list"></i> Kategorien</a>
          <div class="dropdown-content">
            <?php foreach($categories as $category) : ?>
            <a href="/views/categories.php?cat=<?php echo $category['id'] ?>"><?php echo $category['category'] ?></a>
            <?php endforeach ?>
          </div>
      </div>
      </li>
      <li><a href="/views/contact.php"><i class="fas fa-pen-to-square"></i> Kontakt</a></li>
      <?php if (isset($_SESSION['user_id'])) : ?>
      <?php echo '<li><a href="/views/logout.php"><i class="fas fa-right-from-bracket"></i> Ausloggen</a></li>' ?>
      <?php endif ?>
      <?php if (!isset($_SESSION['user_id'])) : ?>
      <?php echo '<li><a href="/views/login.php"><i class="fas fa-right-to-bracket"></i> Einloggen</a></li>' ?>
      <?php endif ?>
      <?php if (isset($_SESSION['user_id'])) :
      $cartItemsCount = count_products_for_user($_SESSION['user_id']); ?>
      <?php endif ?>
      <?php if (isset($_SESSION['user_id'])) : ?>
      <li>
        <a href="/views/cart.php"><i class="fa-solid fa-cart-shopping"></i>
          Warenkorb (<?php echo ($cartItemsCount === null) ? '0' : $cartItemsCount ?>)</a>
      </li>
      <?php endif ?>
      <label for="toggle-btn" class="hide-menu-btn"><i class="fas fa-times"></i></label>
    </ul>
  </nav>
</navbar>