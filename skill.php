<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>privacy</title>
    <link rel="stylesheet" type="text/css" href="css/skill.css" />
</head>

<body>
    <h2>Myスキル</h2>
    <form action="skill_create.php" method="POST">
        <div id="area1">
            <div class="t-area">
                <p>マネジメント経験</p>
                <select id="ninzuu" name="ninzuu">
                    <option value="5人以下">5人以下</option>
                    <option value="6～10人">6～10人</option>
                    <option value="11～20人">11～20人</option>
                    <option value="21～50人">21～50人</option>
                    <option value="51～100人">51～100人</option>
                    <option value="101～500人">101～500人</option>
                    <option value="501人以上">501人以上</option>
                </select>
            </div>
            <div class="t-area">
                <p>Office</p><input type="text" name="furigana" class="i-size" placeholder="ヤマダ　タロウ">
            </div>
            <div class="t-area">
                <p>性別</p>
                <select id="sei" name="gender">
                    <option value="男">男性</option>
                    <option value="女">女性</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="t-area">
                <p>語学</p><input type="date" id="umare" name="umare" class="i-size">
            </div>
            <div class="t-area">
                <p>TOEIC</p><input type="number" id="nenrei" name="nenrei" class="i-size" min="0">
            </div>
            <div class="t-area">
                <p id="p-skill">その他スキル </p><textarea type="text" id="sonota" name="sonota" placeholder="ヤマダ　タロウ"></textarea>
            </div>
            <button>保存</button>
        </div>
    </form>
    <button id="modoru">Mainに戻る</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $("#modoru").click(function() {
            window.location.href = "mypage.php";
        });
    </script>
</body>

</html>