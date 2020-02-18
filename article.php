<?php session_start();
require "includes/config.php";
$idses = session_id();
$account = mysqli_query($connection, "SELECT * FROM `users` WHERE `login`='$idses'");
$acc = mysqli_fetch_assoc($account);
if (empty($acc) ) {
  $guest = true;
}
?>

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

    <?php
      $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id`=".(int)$_GET['id']);

      if (mysqli_num_rows($articles) <= 0)
      {
        ?>
        <div id="content">
          <div class="container">
            <div class="row">
              <section class="content__left col-md-8">
                <div class="block">
                  <h3>Статья не найдена!</h3>
                  <div class="block__content">
                    <img src="media/images/post-image.jpg">

                    <div class="full-text">
                      Запрашиваемая вами статья не существует!
                    </div>
                  </div>
                </div>

              </section>
              <section class="content__right col-md-4">
                <?php include "includes/sidebar.php"; ?>
              </section>
            </div>
          </div>
        </div>
        <?php
      } else
      {
        $art = mysqli_fetch_assoc($articles);
        mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = ". (int)$art['id']);
        ?>
        <div id="content">
          <div class="container">
            <div class="row">
              <section class="content__left col-md-8">
                <div class="block">
                  <h3><?php echo $art['title'];?></h3>
                  <a><?php echo $art['views'];?> просмотров</a>
                  <div class="block__content">
                    <img src="static/images/<?php echo $art['image'];?>" style="max-width: 100%;">
                    <div class="full-text"> <?php echo $art['text'];?></div>
                  </div>

                  <?php if ($idses == 'admin' || $idses == 'editor'): ?>
                    <div align="right">
                    <a href="edit-article-form.php?id=<?php echo $art['id']; ?>">Редактировать</a>
                  <?php endif; ?>
                  <?php if ($idses == 'admin'): ?>
                    <a href="delete-article.php?id=<?php echo $art['id']; ?>">Удалить</a>
                    </div>
                  <?php endif; ?>
                </div>

          <?php if ($guest == false): ?>

          <div class="block">
            <a href="#comment-add-form">Добавить свой</a>
            <h3>Комментарии</h3>
            <div class="block__content">
              <div class="articles articles__vertical">

                <?php
                $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int)$art['id'] .  " ORDER BY `id` DESC");

                if (mysqli_num_rows($comments) <= 0)
                {
                  echo "Нет комментариев.";
                }
                  while ($comment = mysqli_fetch_assoc($comments))
                  {
                    ?>
                    <article class="article">
                      <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']);?>);"></div>
                      <div class="article__info">
                        <a href="/article.php?$id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['author'];?></a>
                        <div class="article__info__meta">
                        </div>
                        <div class="article__info__preview"><?php echo strip_tags($comment['text']); ?></div>
                      </div>
                    </article>
                    <?php
                  }
               ?>

              </div>
            </div>
          </div>

          <div class="block" id="comment-add-form">
            <h3>Добавить комментарий</h3>
            <div class="block__content">
              <form class="form" method="POST" action="" #comment-add-form">
                <?php
                if (isset($_POST['do_post'])) {
                  $errors = array();

                  if ($_POST['name'] == '') {
                    $errors[] = "Введите имя!";
                  }

                  if ($_POST['nickname'] == '') {
                    $errors[] = "Введите ваш никнейм!";
                  }

                  if ($_POST['email'] == '') {
                    $errors[] = "Введите email!";
                  }

                  if ($_POST['text'] == '') {
                    $errors[] = "Введите текст комментария!";
                  }

                  if (empty($errors)) {
                    mysqli_query($connection, "INSERT INTO `comments` (`author`,`nickname`,`email`,`text`,`pubdate`,`articles_id`) VALUES ('".$_POST['name']."','".$_POST['nickname']."','".$_POST['email']."','".$_POST['text']."',NOW(),'".$art['id']."')");
                    echo '<span style="color: green"; font-weight: bold; margin-bottom: 10px; display: block;>Комментарий успешно добавлен</span>';
                  } else {
                    // вывести ошибку
                    echo '<span style="color: red"; font-weight: bold; margin-bottom: 10px; display: block;>'.$errors['0'].'</span>';
                  }
                }
                 ?>
                <div class="form__group">
                  <div class="row">
                    <div class="col-md-4">
                      <input type="text" class="form__control" required="" name="name" placeholder="Имя" value="<?php echo $_POST['name']; ?>">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form__control" required="" name="nickname" placeholder="Никнейм" value="<?php echo $_POST['nickname']; ?>">
                    </div>
                    <div class="col-md-4">
                      <input type="text" class="form__control" required="" name="email" placeholder="Email" value="<?php echo $_POST['email']; ?>">
                    </div>
                  </div>
                </div>
                <div class="form__group">
                  <textarea name="text" required="" class="form__control" placeholder="Текст комментария ..."><?php echo $_POST['text']; ?></textarea>
                </div>
                <div class="form__group">
                  <input type="submit" class="form__control" name="do_post" value="Добавить комментарий">
                </div>
              </form>
            </div>
          </div>

        <?php endif; ?>
              </section>
              <section class="content__right col-md-4">
                <?php include "includes/sidebar.php"; ?>
              </section>
            </div>
          </div>
        </div>
        <?php
      }
    ?>

    <?php include "includes/footer.php"; ?>

  </div>

</body>
</html>
