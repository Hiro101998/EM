<?php require('dbconnect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="ja" dir="">
  <head>
    <meta charset="utf-8">
    <title>管理者用システムログイン画面</title>
  </head>
  <body>
    <?php
    //POSTの中身があれば、DBのmembersテーブルからIDとPWを取得
      if($_POST['manager_id']!='' && $_POST['password']!=''){
        $login = $db->prepare('SELECT * FROM manager WHERE manager_id=? AND password=?');
        //$_POSTの情報とテーブルの状態が一致していたら、$memberに値が入る。
        $login -> execute(array(
          $_POST['manager_id'],
          $_POST['password']
        ));
      $member = $login -> fetch();
      if($member){
        //ログイン成功の処理
        $_SESSION['login']='M_success';
        header('Location:M_success.php');
        exit();
      }else{//ログイン失敗時の処理{
        $error['login'] ='failed';
      }
      }
     ?>
  <div style="text-align:center;">
    <h1>〇〇会社 社員管理システム</h1>
    <h2>管理者用ログインページ</h2>
    <form class="" action="" method="post">
      <p>ID<input type="text" name="manager_id" value="<?php echo htmlspecialchars($_POST['member_id'],ENT_QUOTES);?>"></p>
      <p>パスワード<input type="password" name="password" value="<?php echo htmlspecialchars($_POST['password'],ENT_QUOTES);?>"></p>
      <?php if($_POST && $error['login']='failed'):?>
        <p class="error">IDもしくはパスワードに誤りがあります。</p>
      <?php endif;?>
      <p><input type="submit" name="submit" value="ログインする"></p>
      <p><a href="login.php">戻る</a></p>
  </div>
