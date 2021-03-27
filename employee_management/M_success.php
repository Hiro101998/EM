<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php if($_SESSION['login']!='M_success'){
      header('Location:M_login.php');
    }
    ?>
    <p><a href="M_add.php">・社員データの追加</a></p>
    <p><a href="M_search.php">・社員データの修正・削除</a></p>
   <p><a href="M_login.php">・管理者ログインページに戻る</a></p>
  </body>
</html>
