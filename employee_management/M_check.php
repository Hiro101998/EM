<?php
require('dbconnect.php');
session_start();
if($_SESSION['login']!='M_success'){
  header('Location:M_login.php');
}
?>

<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    $detail = $db->prepare('SELECT * FROM detail,department WHERE detail.department_id=department.department_id AND id=?');
    $detail->execute(array(
      $_REQUEST['id']
    ));
    foreach ($detail as $result) {
       print( 'ID '.$result['id'].'氏名：'.$result['name'].' 部署名'.$result['department_name'].' 生年月日：'.$result['birthday']).
      ' 性別：'.$result['gender'].' 電話番号：'.$result['tel'].'<br>';
      }
      ?>
    <p>この社員データを削除してよろしいですか？</p>
    <a href="M_delete.php?id=<?php print(htmlspecialchars($result['id']));?>">はい</a>/
    <a  href="M_search.php">戻る</a>
  </body>
</html>
