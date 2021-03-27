<?php
try {
    $db = new PDO('mysql:dbname=zinzi;host=××××××××;charset=utf8', '×××××××', '××××××××');
  } catch(PDOException $e) {
      echo 'DB接続エラー: ' . $e->getMessage();
  }
?>
