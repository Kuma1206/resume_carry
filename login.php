<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css" />
</head>

<body>
    <form action="login_act.php" method="POST">
        <div class="login-form">
            <h2>ログイン</h2>
                <input type="email" id="email" class="b-login" name="email" placeholder="メールアドレス" required>
                <div>
                    <input type="password" id="password" class="b-login" name="password" placeholder="パスワード" required>
                </div>
                <span class="password-toggle" id="togglePassword">👁️</span>

                <button type="submit">ログイン</button>
            <p id="shinki"><a href="shinki.php">新規登録しちぃなよ</a></p>
        </div>
    </form>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#togglePassword').click(function() {
                    const passwordInput = $('#password');
                    const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                    passwordInput.attr('type', type);
                    $(this).text(type === 'password' ? '👁️' : '👁️');
                });
            });
        </script>
</body>

</html>