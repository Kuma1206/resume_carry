<?php
// データ受け取り
session_start();
include('functions.php');

$email = $_POST['email'];
$password = $_POST['password'];

// DB接続
$pdo = connect_to_db();

// ユーザーの存在とパスワードの照合を行うSQLクエリ
$sql = 'SELECT * FROM shinki_touroku WHERE email=:email AND deleted_at IS NULL';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザーの取得とパスワードの照合
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user || !password_verify($password, $user['password'])) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=login.php>ログイン</a>";
    exit();
}

// var_dump($_POST);
// exit();

else {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $user['is_admin'];
    $_SESSION['user_id'] = $user['id']; // ユーザーIDを保存
    $_SESSION['email'] = $user['email'];

    // リダイレクト先を決定
    if ($user['is_admin'] == 0) {
        header("Location: mypage.php");
    } elseif ($user['is_admin'] == 20) {
        header("Location: kanri.php");
    }
    exit();
}

?>
