<?php
require('dbconnect.php');
session_start();
if($_SESSION['login']!='M_success'){
  header('Location:M_login.php');
}
$id=$_REQUEST['id'];
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>処理完了</title>
  </head>
  <body>
<?php
$delete = $db->prepare('DELETE FROM detail WHERE id=?');
$delete->execute(array($id));
 ?>
 <p>処理が完了しました</p>
 <a href="M_search.php">戻る</a>
  </body>
</html>
