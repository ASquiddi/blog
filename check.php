<?php
  require "includes/config.php";

  $login = $_POST['login'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $pass_conf = $_POST['pass_conf'];
  $but = $_POST['button reg'];

  if($login != 'admin' || $login != 'editor') {
    $role = 'simple';
  } elseif ($login == 'admin' && $password == 'admin') {
    $role = 'admin';
  } elseif ($login == 'editor' && $password == 'editor') {
    $role = 'editor';
  }
    $errors = array();

    if ($login == '') {
      $errors[] = "Введите логин!";
    }

    if ($name == '') {
      $errors[] = "Введите имя!";
    }

    if ($password == '') {
      $errors[] = "Введите пароль!";
    }

    if ($pass_conf == '') {
      $errors[] = "Введите подтверждение пароля!";
    }

    if ($password != $pass_conf) {
      $errors[] = "Пароли не совпадают!";
    }

    if (empty($errors))
    {
      mysqli_query($connection, "INSERT INTO `users` (`login`,`name`,`password`,`role`) VALUES ('".$login."','".$name."','".$password."','".$role."')");
      echo '<span style="color: green"; font-weight: bold; margin-bottom: 10px; display: block;>Пользователь зарегистрировался!</span>';
      header("Location: http://localhost/proba.ru");
    } else
    {
      echo '<span style="color: red"; font-weight: bold; margin-bottom: 10px; display: block;>'.$errors['0'].'</span>';
    }

  mysqli_close($connection);
 ?>
