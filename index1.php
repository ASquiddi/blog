<?
session_start();
?>

<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
  <meta charset="utf-8">
  <title><?php echo $config['title'];?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div class="container mt-4">
    <?php
    if ($_SESSION['userid'] == ''):
     ?>
    <div class="row">
      <div class="col">
        <h1>Форма регистрации</h1>
        <form action="check.php" method="post">
          <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
          <input type="text" name="name" class="form-control" id="name" placeholder="Введите имя"><br>
          <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
          <input type="password" class="form-control" name="pass_conf" id="password_conf" placeholder="Подтвердите пароль"><br>
          <button type="submit" name="button reg" class="btn btn-success">Зарегистрироваться</button>
        </form>
      </div>
      <div class="col">
        <h1>Форма авторизации</h1>
        <form action="auth.php" method="post">
          <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
          <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
          <button type="submit" name="button auth" class="btn btn-success">Авторизоваться</button>
        </form>
      </div>
      <?php else: ?>
        <p>Привет, <?=$_SESSION['userid']?>. Чтобы выйти, нажми <a href="/exit.php">здесь</a>.</p>
      <?php endif;?>
    </div>
  </div>
</body>

</html>
