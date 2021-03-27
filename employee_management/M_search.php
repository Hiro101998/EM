<?php require('dbconnect.php');
session_start();
if($_SESSION['login']!='M_success'){
  header('Location:M_login.php');
}
?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>社員管理システム</title>
  </head>
  <body>
    <p>名前検索</p>
    <form class="" action="" method="post">
      <input type="text" name="name" value="<?php print(htmlspecialchars($_POST['name']));?>">
      <input type="submit" name="" value="検索">
      </form>
      <br>

  <?php
    if($_POST['name']){
    print(htmlspecialchars($_POST['name'].'の検索結果',ENT_QUOTES));
    }
      $search = $db->prepare('SELECT * FROM detail,department WHERE detail.department_id=department.department_id AND name = ?');
      $search -> execute(array(
      $_POST['name']
      ));
  ?>
    <br>
    <?php foreach($search as $result):?>
      <?php $img = base64_encode($result['image']);?>
      <p><img src="data:<?php echo $result['ext'] ?>;base64,<?php echo $img; ?>"
        alt="画像なし"style="width:50px;height:50px">
        <?php print( 'ID '.$result['id'].' 部署：'.$result['department_name'].' 氏名：'.$result['name'].' 生年月日：'.$result['birthday']).
      ' 性別：'.$result['gender'].' 電話番号：'.$result['tel'].'<br>';?>
      <a href="M_update.php?id=<?php print(htmlspecialchars($result['id']));?>">修正</a>/
      <a href="M_check.php?id=<?php print(htmlspecialchars($result['id']));?>">削除</a></p>
  <?php endforeach;?>

  <form class="" action="" method="post">
    <input type="submit" name="all" value="全職員を表示">
  </form>
<?php if($_POST['all']) :?>
  <p>全職員一覧</p>
    <?php
    $member = $db->query('SELECT * FROM detail,department WHERE detail.department_id=department.department_id');

    ?>
    <?php foreach($member as $all):?>
    <?php $img = base64_encode($all['image']);?>
      <img src="data:<?php echo $all['ext'] ?>;base64,<?php echo $img; ?>" alt="画像なし"style="width:50px;height:50px">
      <p><?php print(htmlspecialchars('社員ID:'.$all['id'].'部署：'.$all['department_name'].' 氏名：'.$all['name'].' 生年月日：'.$all['birthday'].
      ' 性別：'.$all['gender'].' 電話番号：'.$all['tel'],ENT_QUOTES));?></p>
      <a href="M_update.php?id=<?php print(htmlspecialchars($all['id']));?>">修正</a>/
      <a href="M_check.php?id=<?php print(htmlspecialchars($all['id']));?>">削除</a>
      <hr>
<?php endforeach;?>
<?php endif;?>
<p><a href="M_success.php">戻る</a></p>
  </body>
</html>
