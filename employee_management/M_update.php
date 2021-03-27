<?php
require('dbconnect.php');
session_start();
if($_SESSION['login']!='M_success'){
  header('Location:M_login.php');
}
if(!is_numeric($_POST['tel'])){
  $error['tel']='number';
  }
//部署名が存在するかチェック
  $stmt = $db->prepare('SELECT * FROM department WHERE department_name=?');
  $stmt->execute(array(
  $_POST['department']));
  $department = $stmt -> fetch();
if(!$department){
    $error['department']='failed';
    }
  $id=$_REQUEST['id'];
  $detail=$db->prepare('SELECT * FROM detail,department WHERE detail.department_id=department.department_id AND id=?');
  $detail->execute(array($id));
  $result= $detail->fetch();
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>更新画面</title>
  </head>
  <body>
    <form class="" action="" method="post" enctype="multipart/form-data">
      <p>氏名<input type="text" name="name" value="<?php print(htmlspecialchars($result['name'],ENT_QUOTES))?>"></p>
      <p>生年月日<input type="text" name="birthday" value="<?php print(htmlspecialchars($result['birthday'],ENT_QUOTES))?>"></p>
      <p>性別<input type="text" name="gender" value="<?php print(htmlspecialchars($result['gender'],ENT_QUOTES))?>"></p>
      <p>所属部署<input type="text" name="department" value="<?php print(htmlspecialchars($result['department_name'],ENT_QUOTES))?>"></p>

       <?php if($_POST['department'] && $error['department']==='failed'):?>
         <!-- DBに無い部署はエラー表示 -->
        <p class="error">その部署名は存在しません</p>
      <?php endif;?>

      <p>電話番号<input type="text" name="tel" value="<?php print(htmlspecialchars($result['tel'],ENT_QUOTES))?>"></p>
      <?php if($_POST['tel'] && $error['tel']==='number'):?>
        <p class="error">※電話番号は半角数字のみで記入してください</p>
      <?php endif;?>
      <p>写真<input type="file" name="image" ></p>
      <input type="submit" value="更新する">
    </form>
    <?php//変数の準備
      $img=file_get_contents($_FILES['image']['tmp_name']);//$imgの作成
      //department_nameからidを取得
      $stmt = $db->prepare('SELECT department_id FROM department WHERE department_name=?');
      $stmt->execute(array($_POST['department']));
      $result= $stmt->fetch();
      foreach($result as $department){
        $department_id= $department['department_id'];}
      ?>

    <?php if($_POST && !$error):?>
      <?php $modify = $db->prepare('UPDATE detail SET name=?,birthday=?, gender=?,department_id=?,tel=?,image=?,created=NOW() WHERE id=?');
      $modify->execute(array(
        $_POST['name'],
        $_POST['birthday'],
        $_POST['gender'],
        $department_id,
        $_POST['tel'],
        $img,
        $id
      ));
      print('更新が完了しました');?>
    <p><a href="M_search.php">戻る</a></p>
  <?php endif;?>
  </body>
</html>
