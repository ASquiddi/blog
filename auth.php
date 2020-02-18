<?php
  session_id($_POST['login']);
  session_start();
  require "includes/config.php";

  $login = $_POST['login'];
  $password = $_POST['password'];

  $account = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

  if (mysqli_num_rows($account) == 0) {
    echo "Вы не зарегистрированы!";
  } else {
      header("Location: http://localhost/proba.ru");
    }

    mysqli_close($connection);
?>
