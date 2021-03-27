<?php require('dbconnect.php');
session_start();
if($_SESSION['login']!='succsess'){
header('Location:login.php');

}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>社員管理システム</title>
  </head>
  <body>
    <form class="" action="" method="post">
      <input type="submit" name="all" value="全職員を表示">
    </form>
    <?php if($_POST['all']):?>
<p>全職員一覧</p>
  <?php
  $member = $db->query('SELECT * FROM detail,department WHERE detail.department_id=department.department_id');
  ?>

  <?php foreach($member as $all):?>
    <p><?php print(htmlspecialchars('氏名：'.$all['name'].' 部署：'.$all['department_name'].
    ' 性別：'.$all['gender'].' 電話番号：'.$all['tel'],ENT_QUOTES));?></p>
    <hr>
<?php endforeach;?>
<?php endif;?>

<?php $stmt=$db->query('SELECT * FROM department');?>
     <!-- departmentテーブルからデータを取得 -->
    <form class="" action="" method="post">
    <p>部署検索<select name="department">
      <?php foreach ($stmt as $department): ?>
    <?php echo '<option value="', $department['department_id'], '">', $department['department_name'], '</option>';?>
      <?php endforeach ;?>
    </select></p>
    <input type="submit" name="" value="検索">
  </form>


  <?php
    if($_POST){
    print('検索結果');
    }
      $search = $db->prepare('SELECT * FROM detail WHERE department_id = ?');
      $search -> execute(array(
      $_POST['department']
      ));
  ?>

    <?php foreach($search as $result):?>
      <p><?php print(htmlspecialchars('氏名：'.$result['name'].' 性別：'.$result['gender'].' 電話番号：'.$result['tel'],ENT_QUOTES));?></p>
      <hr>
  <?php endforeach;?>
<p><a href="login.php">ログイン画面に戻る</a></p>

  </body>
</html>
