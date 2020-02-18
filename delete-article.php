<?php
  require "includes/config.php";
  $articles = mysqli_query($connection, "DELETE FROM `articles` WHERE `id`=".(int)$_GET['id']);
  mysqli_close($connection);
  header("Location: http://localhost/proba.ru");
?>
