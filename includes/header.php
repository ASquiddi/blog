<?php session_start();
require "includes/config.php";
$idses = session_id();
$account = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='$idses'");
$acc = mysqli_fetch_assoc($account);
if (empty($acc) ) {
  $guest = true;
}
?>

<header id="header">
  <div class="header__top">
    <div class="container">
      <div class="header__top__logo">
        <h1><?php echo $config['title'];?></h1>
      </div>
      <nav class="header__top__menu">
        <ul>
          <li><a href="./index.php">Главная</a></li>
          <li><a href="pages/about_me.php">Обо мне</a></li>
          <?php if ($guest == true) {
            ?>
            <li><a href="./index1.php">Войти или авторизироваться</a></li>
            <?php
          } else { ?>
          <li>Привет, <?php echo $idses; ?></a></li>
        <?php } ?>
        </ul>
      </nav>
    </div>
  </div>

  <?php
  $categories_q = mysqli_query($connection, "SELECT * FROM `articles_categories`");
  $categories = array();
  while ($cat = mysqli_fetch_assoc($categories_q))
  {
    $categories[] = $cat;
  }
  ?>

  <div class="header__bottom">
    <div class="container">
      <nav>
        <ul>
          <?php
          foreach ($categories as $cat)
          {
              ?>
              <li><a href="/$articles.php?categorie=<?php echo $cat['id']; ?>"><?php echo $cat['title']; ?></a></li>
              <?php
            }
           ?>
           <?php if ($guest == false): ?>
             <li><a href="./logout.php?">Выйти</a></li>
           <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>
</header>
