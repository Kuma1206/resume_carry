<?php
include('functions.php');

// フォームデータの確認
if (
  !isset($_POST['namae']) || $_POST['namae'] === '' ||
  !isset($_POST['furigana']) || $_POST['furigana'] === '' ||
  !isset($_POST['email']) || $_POST['email'] === '' ||
  !isset($_POST['password']) || $_POST['password'] === ''
) {
  exit('データが足りません');
}

// DB接続情報
$dbn = 'mysql:dbname=tenshokukanri_01;charset=utf8mb4;port=3308;host=localhost';
$user = 'root';
$pwd = '';

// POSTデータ取得
$namae = $_POST['namae'];
$furigana = $_POST['furigana'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードをハッシュ化

// データベース接続
$pdo = connect_to_db();

// メールアドレスの重複チェック
$sql = 'SELECT COUNT(*) FROM shinki_touroku WHERE email=:email';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  // 既に登録されている場合のメッセージ
  $message = "すでに登録されているユーザです．";
  $login_link = '<a href="login.php">login</a>';
} else {
  // 新規登録処理
  $sql_insert = 'INSERT INTO shinki_touroku (id, namae, furigana, email, password, is_admin, created_at, updated_at, deleted_at) VALUES (NULL, :namae, :furigana, :email, :password, 0, now(), now(), NULL)';
  $stmt_insert = $pdo->prepare($sql_insert);
  $stmt_insert->bindValue(':namae', $namae, PDO::PARAM_STR);
  $stmt_insert->bindValue(':furigana', $furigana, PDO::PARAM_STR);
  $stmt_insert->bindValue(':email', $email, PDO::PARAM_STR);
  $stmt_insert->bindValue(':password', $password, PDO::PARAM_STR);

  try {
    $status = $stmt_insert->execute();
    if ($status) {
      // 登録成功時のメッセージとリダイレクト
      header("Location: touroku_ok.php");
      exit();
    } else {
      $message = "登録に失敗しました．";
    }
  } catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/shinki_create.css" />
  <title>新規登録</title>
</head>

<body>
  <div class="container">
    <?php if (isset($message)) : ?>
      <div class="message">
        <p><?php echo $message; ?></p>
        <?php echo isset($login_link) ? $login_link : ''; ?>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>