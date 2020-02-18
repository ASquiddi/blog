<?php
session_start();
 require "includes/config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title'];?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="media/css/style.css">


</head>
<body>

  <div id="wrapper">
    <?php include "includes/header.php"; ?>

    <div class="block" id="article-edit-form">
    <h3>Редактирование статьи</h3>
    <div class="block__content">
      <form class="form" action="" method="POST">
        <div class="form__group">
          <div class="row">
            <div class="col-md-6 form__group">
              <input type="text" class="form__control" name="headArt" placeholder="Название статьи">
            </div>
            <div class="col-md-6 form__group">
              <select class="form__control" name="catArt">
                <option>Мозг</option>
                <option>Космос</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form__group">
          <textarea name="text" class="form__control" placeholder="Текст статьи ..."></textarea>
        </div>
        <div class="form__group">
          <input type="submit" class="form__control" name="do_change" value="Изменить">
        </div>
      </form>
    </div>
  </div>

  <?php include "includes/footer.php"; ?>

  </div>
  <?php if (isset($_POST['do_change'])){

      $title = $_POST['headArt'];
      $category = $_POST['catArt'];

      if ($category == 'Мозг') {
        $category = 1;
      } elseif ($category == 'Космос') {
        $category = 2;
      }

      $text = $_POST['text'];
      $ed = mysqli_query($connection, "UPDATE `articles` SET `title` = '$title', `text` = '$text', `categorie_id` = $category WHERE `id`=".(int)$_GET['id']);

  } ?>

</body>
</html>
