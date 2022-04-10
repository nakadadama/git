<?php
require_once(dirname(__FILE__) . '/../config/config.php');
require_once(dirname(__FILE__) . '/functions.php');

session_start();

if (isset($_SESSION['USER'])){
  // ログイン済みの場合はHOME画面へ
  header('Location: /');
    exit;
}



 if($_SERVER['REQUEST_METHOD'] == 'POST'){
//POST処理時

//1.入力値を取得
$user_no = $_POST['user_no'];
$password = $_POST['password'];

//echo $user_no.'<br>';
//echo $password;
//exit;

//2.バリテーションチェック
$err =array();
if(!$user_no){
  $err['user_no'] = '社員番号を入力してください。';
}
if(!$password){
  $err['password'] = 'パスワードを入力してください。';
}
if(empty($err)){
  //3.データベースに結合
  $pdo = connect_db();
  

  $sql = "SELECT id,user_no,name FROM user WHERE user_no = :user_no AND password = :password LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':user_no', $user_no, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $stmt->execute();
  $user = $stmt->fetch();

  //var_dump($user);
  //exit;

  if($user){
    $_SESSION['USER'] = $user;

    // 5.HOME画面へ遷移
    header('Location: /');
    exit;
  } else{
    $err['password'] = '認証に失敗しました。';
  }
}




 }else{
   //画面初回アクセス時
   $user_no = "";
        $password = "";
 }
?>
<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     

    <link rel="stylesheet" href="./css/style.css">
    <title>Hello, world!</title>
  </head>
  <body>
      <div class="wrap">
    <h1 class="main_title">Web日報登録</h1>
    <form class="entry-form" method="POST">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label" >社員番号</label>
          <input type="text" class="form-control<?php if (isset($err['user_no'])) echo ' is-invalid'; ?>" name="user_no" value="<?= $user_no ?>" id="exampleInputEmail1" aria-describedby="emailHelp"
          placeholder="社員番号">
          <div class="invalid-feedback"><?= $err['user_no'] ?></div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" name="password" class="form-control<?php if (isset($err['password'])) echo ' is-invalid'; ?>" id="exampleInputPassword1" placeholder="Password">
          <div class="invalid-feedback"><?= $err['password'] ?></div>
        </div>
        
        <button type="submit" class="btn btn-primary">login</button>
      </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

   
  </body>
</html>