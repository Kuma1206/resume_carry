<?php
session_start();
include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行
$sql = 'SELECT * FROM shinki_touroku';
$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $namae = $user['namae'];
    } else {
        $namae = ''; // ユーザーが存在しない場合のデフォルト値
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// SQL実行の処理
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mypage</title>
    <link rel="stylesheet" type="text/css" href="css/kanri.css" />
</head>

<body>

    <div class="overlay"></div>

    <header>
        <div class="header-left">
            <span id="rogo">管理者画面</span>
        </div>
        <div class="header-right">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <span>ようこそ、<?php echo htmlspecialchars($namae, ENT_QUOTES, 'UTF-8'); ?>さん！</span>
                <button id="logout-btn">ログアウト</button>
            <?php else : ?>
                <button id="login-btn">ログイン</button>
            <?php endif; ?>
        </div>
    </header>


    <div class="openbtn1"><span></span><span></span><span></span></div>
    <nav id="g-nav">
        <div id="g-nav-list"><!--ナビの数が増えた場合縦スクロールするためのdiv※不要なら削除-->
            <ul>
                <li><a href="#" id="rirekisho_data">履歴書data</a></li>
                <li><a href="#">職務経歴書data</a></li>
                <li><a href="#">Myアカウント</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>


    <main>

        <!-- 履歴書、職務経歴書、顔写真のセクション -->
        <section class="document-section" style="display:none;">
            <div id="toji">
                <p class="batu">×</p>
            </div>
            <p>！！Fileをアップロードしてください</p>
            <div id="b-popup">
                <label for="resume-upload" class="b-upload" style="text-decoration: none;">
                    <span class="file-label">履歴書を選択</span>
                    <input type="file" id="resume-upload">
                    <p id="file-icon-a" class="file-icon-container"></p>
                </label>
                <label for="job-history-upload" class="b-upload" style="text-decoration: none;">
                    <span class="file-label">職務経歴書を選択</span>
                    <input type="file" id="job-history-upload">
                    <p id="file-icon-b" class="file-icon-container"></p>
                </label>
                <label for="photo-upload" class="b-upload" style="text-decoration: none;">
                    <span class="file-label">顔写真を選択</span>
                    <input type="file" id="photo-upload">
                    <p id="file-icon-c" class="file-icon-container"></p>
                </label>
            </div>
            <button id="bn-up">アップロード</button>
        </section>


        <section id="top">
            <div id="hyou">
                <table>
                    <tr>
                        <th>id</th>
                        <th>名前</th>
                        <th>フリガナ</th>
                        <th>email</th>
                        <th>権限</th>
                        <th>新規登録日</th>
                        <th>更新日</th>
                        <th>削除日</th>
                    </tr>

                    <?php foreach ($result as $record) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['namae'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['furigana'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['is_admin'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['updated_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($record['deleted_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>



    </main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(".openbtn1").click(function() { //ボタンがクリックされたら
            $(this).toggleClass('active'); //ボタン自身に activeクラスを付与し
            $("#g-nav").toggleClass('panelactive'); //ナビゲーションにpanelactiveクラスを付与
        });

        $("#g-nav a").click(function() { //ナビゲーションのリンクがクリックされたら
            $(".openbtn1").removeClass('active'); //ボタンの activeクラスを除去し
            $("#g-nav").removeClass('panelactive'); //ナビゲーションのpanelactiveクラスも除去
        });


        // ログアウト表示
        $('#logout-btn').click(function() {
            if (confirm("ログアウトしますか？")) {
                $.ajax({
                    url: 'logout.php',
                    type: 'POST',
                    success: function(response) {
                        window.location.href = 'login.php';
                    },
                    error: function(xhr, status, error) {
                        console.error('ログアウト時にエラーが発生しました');
                    }
                });
            }
        });


        $('#resume-upload').change(function() {
            var file = $(this)[0].files[0];
            if (file) {
                $('#file-icon-a').text('📄'); // アイコンをファイルのマークに変更する
                $('#file-text').text(file.name); // テキストをファイル名に変更する
            } else {
                $('#file-icon-a').text('📎'); // 元のアイコンに戻す
                $('#file-text').text('履歴書を選択'); // 元のテキストに戻す
            }
        });

        $('#job-history-upload').change(function() {
            var file = $(this)[0].files[0];
            if (file) {
                $('#file-icon-b').text('📄'); // アイコンをファイルのマークに変更する
                $('#file-text').text(file.name); // テキストをファイル名に変更する
            } else {
                $('#file-icon-b').text('📎'); // 元のアイコンに戻す
                $('#file-text').text('職務経歴書を添付'); // 元のテキストに戻す
            }
        });

        $('#photo-upload').change(function() {
            var file = $(this)[0].files[0];
            if (file) {
                $('#file-icon-c').text('📄'); // アイコンをファイルのマークに変更する
                $('#file-text').text(file.name); // テキストをファイル名に変更する
            } else {
                $('#file-icon-c').text('📎'); // 元のアイコンに戻す
                $('#file-text').text('顔写真を添付'); // 元のテキストに戻す
            }
        });

        $("#login-btn").click(function() {
            window.location.href = "login.php";
        });

        // $(".overlay").show(); // ページロード時にオーバーレイを表示
        //     // ログイン時にポップアップを表示する
        //     <?php if (isset($_SESSION['user_id'])) : ?>
        //         $(window).on("load", function() {
        //             $(".document-section").show();
        //         });
        //     <?php endif; ?>

        //     // セクションを閉じる処理
        //     $(".batu").click(function() {
        //         $(".document-section").hide();
        //         $(".overlay").hide();
        //     });
        $("#skill").click(function() {
            window.location.href = "skill.php";
        });

        $("#kojin").click(function() {
            window.location.href = "privacy_read.php";
        });

        $("#gakureki").click(function() {
            window.location.href = "rirekisho_read.php";
        });

        $("#shokureki").click(function() {
            window.location.href = "s_reki.php";
        });

        $("#syokumu").click(function() {
            window.location.href = "shokureki.php";
        });

        $("#plofile").click(function() {
            window.location.href = "plofile.php";
        });

        $("#oubokanri").click(function() {
            window.location.href = "oubo.php";
        });

        $("#rirekisho_data").click(function() {
            window.location.href = "rirekisho_data.php";
        });
    </script>

</body>

</html>