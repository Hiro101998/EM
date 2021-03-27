<?php
require('dbconnect.php');
session_start();
if($_SESSION['login']!='M_success'){
  header('Location:M_login.php');
}
if($_POST['tel'] && !is_numeric($_POST['tel'])){
  $error['tel']='number';
  }
  $member=$db->prepare('SELECT COUNT(*) as cnt FROM detail WHERE name=?');
  $member->execute(array($_POST['name']));
  $record=$member->fetch();
  if($record['cnt']>0){
    $error['name']='duplicate';
  }

 ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>管理者用ページ</title>
  </head>
  <body>
  <p>データを追加する</p>
  <form class="" action="" method="post" enctype="multipart/form-data">

    <p>氏名<input type="text" name="name" value="<?php print(htmlspecialchars($_POST['name'],ENT_QUOTES))?>"></p>
    <?php if($error['name']==='duplicate'):?>
      <p class="error">※その名前は既に登録されています</p>
    <?php endif;?>

    <p>生年月日<input type="date" name="birthday" value="<?php print(htmlspecialchars($_POST['birthday'],ENT_QUOTES))?>"></p>
    <p>性別<select name="gender">

      <option value="男">男</option>
      <option value="女">女</option>
    </select></p>

<?php $stmt=$db->query('SELECT * FROM department');?>
     <!-- departmentテーブルからデータを取得 -->
    <p>所属部署<select name="department_id">
      <?php foreach ($stmt as $department): ?>
    <?php echo '<option value="', $department['department_id'], '">', $department['department_name'], '</option>';?>
      <?php endforeach ;?>
    </select></p>

    <p>電話番号<input type="text" name="tel" value="<?php print(htmlspecialchars($_POST['tel'],ENT_QUOTES))?>"></p>
    <?php if($error['tel']==='number'):?>
      <p class="error">※電話番号は半角数字のみで記入してください</p>
    <?php endif;?>

    <p>写真<input type="file" name="image"></p>
    <input type="submit" value="登録する">

  </form>

  <?php
  $img=file_get_contents($_FILES['image']['tmp_name']);
  	if($_POST && $error==''){
  		$add = $db->prepare('INSERT INTO detail SET name=?,birthday=?, gender=?,department_id=?,tel=?,image=?,created=NOW()');
  		$add->execute(array(
  			$_POST['name'],
        $_POST['birthday'],
        $_POST['gender'],
        $_POST['department_id'],
        $_POST['tel'],
        $img,
  		));
  		header('Location:M_end.php');
  		 exit();
  	}
  ?>

  <p><a href="M_success.php">戻る</a></p>
  </body>
</html>
