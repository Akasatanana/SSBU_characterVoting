<?php
/*
// ローカルでのDB
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_db = 'SSBU_charaVoting';
*/

// レンタルサーバでのDB
$db_host = 'mysql630.db.sakura.ne.jp';
$db_user = 'ssbu-charavoting';
$db_password = 'mkai0894';
$db_db = 'ssbu-charavoting_chara-voting';


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

$sql = "SELECT charaname, damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty FROM characterVoting WHERE username=?";
if ($result = $mysqli->prepare($sql)) {
    $result->bind_param("s", $_POST['username'],);
    $result->execute();

    $result->store_result();
    $rows = $result->num_rows;
    $noVote = ($rows == 0);
    if (!$noVote) {
        $charaname = "";
        $resultlist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $result->bind_result($charaname, $resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7], $resultlist[8], $resultlist[9], $resultlist[10], $resultlist[11], $resultlist[12]);
        $result_array = [];
        while ($result->fetch()) {
            $result_array[$charaname] = [$resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7], $resultlist[8], $resultlist[9], $resultlist[10], $resultlist[11], $resultlist[12]];
        }
        $result->close();
        $result_json = json_encode($result_array);
    }
}
$avelist = [];

foreach ($result_array as $name => $value) {
    // 平均値の読み取り
    $sql = "SELECT damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty
FROM averageCharacterVote WHERE charaname=?";
    if ($result = $mysqli->prepare($sql)) {
        $result->bind_param("s", $name);
        $result->execute();
        $result->store_result();

        $tmplist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

        $result->bind_result($tmplist[0], $tmplist[1], $tmplist[2], $tmplist[3], $tmplist[4], $tmplist[5], $tmplist[6], $tmplist[7], $tmplist[8], $tmplist[9], $tmplist[10], $tmplist[11], $tmplist[12]);
        $result->fetch();
        $avelist[$name] = [$tmplist[0], $tmplist[1], $tmplist[2], $tmplist[3], $tmplist[4], $tmplist[5], $tmplist[6], $tmplist[7], $tmplist[8], $tmplist[9], $tmplist[10], $tmplist[11], $tmplist[12]];
    }
    $result->close();
    $avelist_json = json_encode($avelist);
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="icon" type="image/png" href="../images/else/ssbu_characterVoting_icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>スマブラ投票権!!_自分の投票</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css" media="screen and (min-width: 601px)">
    <link rel="stylesheet" href="../csss/standard-content.css">
    <link rel="stylesheet" href="../csss/myvote.css">
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
            <?php echo $_POST["username"] ?>さんの投票履歴
            <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false" data-text="スマブラ投票権!!〜スマブラキャラ評価投票アプリ〜" data-url="http://ssbu-charavoting.sakura.ne.jp/SSBU_characterVoting/login.php" data-hashtags="スマブラSP" data-size="large">Tweet</a>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </p>
        <?php
        foreach ($result_array as $name => $value) {
            // jpnameの取得
            $sql = "SELECT jpname FROM characterName WHERE name = ?";
            if ($result = $mysqli->prepare($sql)) {
                $result->bind_param("s", $name);
                $result->execute();
                $result->store_result();
                $jpname = "";
                $result->bind_result($jpname);
                $result->fetch();
                $result->close();
            }

            // 得票数の取得
            $sql = "SELECT votenumber FROM averageCharacterVote WHERE charaname = ?";
            if ($result = $mysqli->prepare($sql)) {
                $result->bind_param("s", $name);
                $result->execute();
                $result->store_result();
                $votenum = 0;
                $result->bind_result($votenum);
                $result->fetch();
                $result->close();
            }
            echo '<p class="result-text">', $jpname, 'の投票結果　（',$votenum,'票）</p>';
            echo '<div class="result-area">
            <div class="chart-area">
                <canvas id="', $name, '">
                </canvas>
            </div>
            <img class="chara-image" src="../images/charaImages/', $name, '.png">
        </div>';
        };
        ?>

        <form action="mypage.php" method="post">
            <button class="submit-button" type="submit" name="submit" id="submit">マイページへ</button>
            <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
        </form>

    </div>

    <script>
        function displayChart(id, datalist, avedatalist) {
            var ctx = document.getElementById(id);
            var myRadarChart = new Chart(ctx, {
                //グラフの種類
                type: 'radar',
                //データの設定
                data: {
                    //データ項目のラベル
                    labels: ["火力", "機動力", "防御力", "撃墜力", "逆転力", "立ち回り", "崖", "復帰力", "復帰阻止", "処理性能", "安定力", "飛び道具耐性", "難易度"],
                    //データセット
                    datasets: [{
                        label: "投票の平均値",
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
                        data: avedatalist,
                    }, {
                        label: "貴方の投票",
                        //背景色
                        backgroundColor: "rgba(100,149,237, 0.5)",
                        //枠線の色
                        borderColor: "rgba(0,0,255, 1)",
                        //結合点の背景色
                        pointBackgroundColor: "rgba(0,0,255, 1)",
                        //結合点の枠線の色
                        pointBorderColor: "#fff",
                        //結合点の背景色（ホバ時）
                        pointHoverBackgroundColor: "#fff",
                        //結合点の枠線の色（ホバー時）
                        pointHoverBorderColor: "rgba(0,0,255, 1)",
                        //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                        hitRadius: 5,
                        fill: true,
                        //グラフのデータ
                        data: datalist,
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
        }

        let result = JSON.parse('<?php echo $result_json ?>');
        let averesult = JSON.parse('<?php echo $avelist_json ?>');

        Object.keys(result).forEach(function(name) {
            var val = this[name]; // this は result
            var aveval = averesult[name];
            displayChart(name, val, aveval);
        }, result);
    </script>

</body>

<footer>
    <h1 class="footer-text">
        Respected
        <a href="https://www.smashbros.com/ja_JP/">大乱闘スマッシュブラザーズ</a>
    </h1>
</footer>

</html>