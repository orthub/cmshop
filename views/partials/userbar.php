<?php require_once __DIR__ . '/../../models/cart.php';
require_once __DIR__ . '/../../models/contact.php';
require_once __DIR__ . '/../../controllers/products.php';
require_once __DIR__ . '/../../controllers/userRights.php';
$cartItemsCount = null;
if (isset($_SESSION['user_id'])) {
  $cartItemsCount = count_products_for_user($_SESSION['user_id']);
} ?>

<div class="userbar">
  <?php
  require_once __DIR__ . '/../../models/login.php';
  if (isset($_SESSION['user_id'])) : ?>
  <?php $userName = get_user_name($_SESSION['user_id']); ?>
  <?php $newMessages = count_new_messages_for_userbar() ?>
  <ul>
    <?php if ($role === 'ADMIN') : ?>
    <li><a class="userbar" href="/views/account.php"><i class="fa-solid fa-user-secret"></i> Hallo
        <?php echo $userName ?></a></li>
    <?php endif ?>
    <?php if ($role === 'EMPLOYEE') : ?>
    <li><a class="userbar" href="/views/account.php"><i class="fa-solid fa-user-clock"></i> Hallo
        <?php echo $userName ?></a></li>
    <?php endif ?>
    <?php if ($role === 'CUSTOMER') : ?>
    <li><a class="userbar" href="/views/account.php"><i class="fa-solid fa-user"></i> Hallo
        <?php echo $userName ?></a></li>
    <?php endif ?>
    <?php if ($role === 'ADMIN') : ?>
    <li><a class="userbar" href="/views/dashboard.php"><i class="fa-solid fa-table-cells"></i> Dashboard</a></li>
    <?php endif ?>
    <?php if ($role === 'EMPLOYEE' || $role === 'ADMIN') : ?>
    <li><a class="userbar" href="/views/newPost.php"><i class="fa-solid fa-square-plus"></i>Post</a></li>
    <li><a class="userbar" href="/views/newProduct.php"><i class="fa-solid fa-square-plus"></i>Produkt</a></li>
    <li><a class="userbar" href="/views/post-list.php"><i class="fa-solid fa-rectangle-list"></i>Posts</a></li>
    <li><a class="userbar" href="/views/product-list.php"><i class="fa-solid fa-rectangle-list"></i>Produkte</a>
    </li>
    <li><a class="userbar" href="/views/message-list.php"><i class="fa-solid fa-comment-dots"><small
            class="userbar-message-counter"><?php echo ' ' . $newMessages ?></small></i>Nachrichten</a>
    </li>
    <?php endif ?>
    <li><a class="userbar" href="/views/orders.php"><i class="fa-solid fa-receipt"></i> Bestellungen</a></li>
  </ul>

  <?php endif ?>
</div>