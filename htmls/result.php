<?php
// ローカルでのDB
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_db = 'SSBU_charaVoting';

/*
// レンタルサーバでのDB
$db_host = 'mysql630.db.sakura.ne.jp';
$db_user = 'ssbu-charavoting';
$db_password = 'mkai0894';
$db_db = 'ssbu-charavoting_chara-voting';
*/


$mysqli = @new mysqli(
    $db_host,
    $db_user,
    $db_password,
    $db_db
);

if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

$charaname = explode(".", explode("/", $_POST["charaurl"])[4])[0];
if ($_POST["select-style"] == "vote") {
    // 投票済みでないかのチェック
    $sql = "SELECT username, charaname FROM characterVoting WHERE username=? AND charaname=?";
    if ($result = $mysqli->prepare($sql)) {
        $result->bind_param("ss", $_POST['username'], $charaname);
        $result->execute();
        $result->store_result();
        $rows = $result->num_rows;
        $alreadyVoted = ($rows != 0);
        $result->close();
        if (!$alreadyVoted) {
            // 投票の反映
            $stmt = $mysqli->prepare('INSERT INTO characterVoting (username, charaname, damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
            )');

            $stmt->bind_param('ssiiiiiiiiiiiii', $_POST['username'], $charaname, $_POST['damage'], $_POST['mobility'], $_POST['defense'], $_POST['burst'], $_POST['reversal'], $_POST['neutral'], $_POST['edge'],$_POST['recovery'],$_POST['edgeguard'],$_POST['easywin'], $_POST['projectiles'],$_POST['consistency'], $_POST['difficulty']);
            $stmt->execute();
            $stmt->close();

            // 平均値の再計算

            $sql = "SELECT damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty FROM characterVoting WHERE charaname = ?";
            if ($result = $mysqli->prepare($sql)) {
                $result->bind_param("s", $charaname);
                $result->execute();

                $result->store_result();
                $rows = $result->num_rows;
                $resultlist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                $result->bind_result($resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7], $resultlist[8], $resultlist[9], $resultlist[10], $resultlist[11], $resultlist[12]);

                $newavelist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                while ($result->fetch()) {
                    for ($i = 0; $i < count($resultlist); $i++) {
                        $newavelist[$i] += $resultlist[$i];
                    }
                }
                for ($i = 0; $i < count($resultlist); $i++) {
                    $newavelist[$i] /= $rows;
                }
                $result->close();
            }

            // 平均値データの存在を確認

            $sql = "SELECT * FROM averageCharacterVote WHERE charaname=?";
            if ($result = $mysqli->prepare($sql)) {
                $result->bind_param("s", $charaname);
                $result->execute();

                $result->store_result();
                $rows = $result->num_rows;
                $result->close();
                $alreadyExists = ($rows != 0);

                if ($alreadyExists) {
                    // 平均値データが存在すれば，UPDATE

                    // 平均値の登録
                    $stmt = $mysqli->prepare('UPDATE averageCharacterVote
                    SET damage = ?, mobility = ?, defense = ?, burst = ?, reversal = ?, neutral = ?, edge = ?,recovery = ?,edgeguard = ?,easywin = ?, projectiles = ?, consistency = ?, difficulty = ?
                    WHERE charaname = ?');
                    $stmt->bind_param('ddddddddddddds', $newavelist[0], $newavelist[1], $newavelist[2], $newavelist[3], $newavelist[4], $newavelist[5], $newavelist[6], $newavelist[7], $newavelist[8], $newavelist[9],$newavelist[10],$newavelist[11],$newavelist[12], $charaname);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // そうでなければINSERT
                    $stmt = $mysqli->prepare('INSERT INTO averageCharacterVote (
                        charaname, damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty
                    ) VALUES (
                        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                    )');

                    $stmt->bind_param('sddddddddddddd', $charaname, $newavelist[0], $newavelist[1], $newavelist[2], $newavelist[3], $newavelist[4], $newavelist[5], $newavelist[6], $newavelist[7], $newavelist[8], $newavelist[9], $newavelist[10], $newavelist[11], $newavelist[12]);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }
}

$sql = "SELECT damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty
FROM averageCharacterVote WHERE charaname=?";
if ($result = $mysqli->prepare($sql)) {
    $result->bind_param("s", $charaname);
    $result->execute();
    $result->store_result();

    $avelist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $result->bind_result($avelist[0], $avelist[1], $avelist[2], $avelist[3], $avelist[4], $avelist[5], $avelist[6], $avelist[7], $avelist[8], $avelist[9], $avelist[10], $avelist[11], $avelist[12]);
    $result->fetch();
    $avelist_json = json_encode($avelist);
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="icon" type="image/png" href="../images/else/ssbu_characterVoting_icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>スマブラ投票権!!_結果閲覧</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <link rel="stylesheet" href="../csss/standard-content.css">

    <link rel="stylesheet" href="../csss/result.css">
    <script src="../Library/chart.js"></script>
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>
</head>

<header>
    <h1>
        <a href="../login.php"><img class="header-image" src="../images/else/ssbu_characterVoting_icon.png" alt="スマブラ投票権!!"></a>
        スマブラ投票権!!
    </h1>

    <h1>
        ようこそ，<?php echo $_POST["username"]; ?>さん　
    </h1>
</header>

<body>
    <div class="container">
        <p>
            <?php
            if ($_POST["select-style"] == 'vote') {
                if ($alreadyVoted) {
                    echo "エラー：各ファイターへの投票は一人一票までです．";
                } else {
                    echo "投票が完了しました！";
                }
            }
            ?>
        </p>
        <p class="result-text">投票結果（全投票の平均値）：</p>
        <div class="result-area">
            <div class="chart-area">
                <canvas id="myRadarChart">
                </canvas>
            </div>
            <img class="chara-image" src=<?php echo $_POST["charaurl"]; ?>>
        </div>
        <form action="mypage.php" method="post">
            <button class="submit-button" type="submit" name="submit" id="submit">マイページへ</button>
            <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
        </form>

    </div>

    <script>
        var newavelist = JSON.parse('<?php echo $avelist_json; ?>');
        var ctx = document.getElementById("myRadarChart");
        var myRadarChart = new Chart(ctx, {
            //グラフの種類
            type: 'radar',
            //データの設定
            data: {
                //データ項目のラベル
                labels: ["火力", "機動力", "防御力", "撃墜力", "逆転力", "立ち回り", "崖", "復帰力", "復帰阻止", "処理性能", "安定力", "飛び道具耐性", "難易度"],
                //データセット
                datasets: [{
                    label: "",
                    //背景色
                    backgroundColor: "rgba(204,255,204, 0.5)",
                    //枠線の色
                    borderColor: "rgba(0,128,0, 1)",
                    //結合点の背景色
                    pointBackgroundColor: "rgba(0,128,0, 1)",
                    //結合点の枠線の色
                    pointBorderColor: "#fff",
                    //結合点の背景色（ホバ時）
                    pointHoverBackgroundColor: "#fff",
                    //結合点の枠線の色（ホバー時）
                    pointHoverBorderColor: "rgba(0,128,0, 1)",
                    //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                    hitRadius: 5,
                    fill: true,
                    //グラフのデータ
                    data: newavelist,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        min: 0,
                        max: 10,
                    },
                }
            }
        });
    </script>

</body>

<footer>
    <h1 class="footer-text">
        Respected
        <a href="https://www.smashbros.com/ja_JP/">大乱闘スマッシュブラザーズ</a>
    </h1>
</footer>

</html>