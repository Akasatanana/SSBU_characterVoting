<?php
$parameters = [
    "damage" => "火力",
    "mobility" => "機動力",
    "defense" => "防御力",
    "burst" => "撃墜力",
    "reversal" => "逆転力",
    "neutral" => "立ち回り",
    "edge" => "崖",
    "recovery" => "復帰力",
    "edgeguard" => "復帰阻止",
    "easywin" => "処理性能",
    "projectiles" => "飛び道具耐性",
    "consistency" => "安定力",
    "difficulty" => "難易度"
];
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
if (!isset($_POST["parameter"])) {
    $_POST["parameter"] = "damage";
}
$orderparameter = $_POST["parameter"];
// 平均データの取得
$sql = "SELECT charaname, damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty FROM averageCharacterVote ORDER BY " . $orderparameter . " DESC";
if ($result = $mysqli->prepare($sql)) {
    $result->execute();
    $result->store_result();

    $charaname = "";
    $resultlist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $result->bind_result($charaname, $resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7], $resultlist[8], $resultlist[9], $resultlist[10], $resultlist[11], $resultlist[12]);
    $result_array = [];
    while ($result->fetch()) {
        $result_array[$charaname] = [$resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7], $resultlist[8], $resultlist[9], $resultlist[10], $resultlist[11], $resultlist[12]];
    }
    $result_json = json_encode($result_array);
    $result->close();

    $myresult_array = [];
    // 自分の投票の取得
    foreach ($result_array as $name => $value) {
        $sql = "SELECT damage, mobility, defense, burst, reversal, neutral, edge, recovery, edgeguard, easywin, projectiles, consistency,difficulty FROM characterVoting WHERE username=? AND charaname=?";
        if ($result = $mysqli->prepare($sql)) {
            $result->bind_param("ss", $_POST['username'], $name);
            $result->execute();
            $result->store_result();

            $mylist = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

            $result->bind_result($mylist[0], $mylist[1], $mylist[2], $mylist[3], $mylist[4], $mylist[5], $mylist[6], $mylist[7], $mylist[8], $mylist[9], $mylist[10], $mylist[11], $mylist[12]);
            $result->fetch();
            $result->close();
        }
        $myresult_array[$name] = [$mylist[0], $mylist[1], $mylist[2], $mylist[3], $mylist[4], $mylist[5], $mylist[6], $mylist[7], $mylist[8], $mylist[9], $mylist[10], $mylist[11], $mylist[12]];
    }
    $myresult_json = json_encode($myresult_array);
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
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css" media="screen and (min-width: 601px)">
    <link rel="stylesheet" href="../csss/standard-content.css">

    <link rel="stylesheet" href="../csss/ranking.css">
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
    <p class="explain-text">各項目をクリック・タップすると，項目毎のランキングが閲覧できます．</p>
    <form class="parameter-form" action="" method="post">
        <button name="parameter" value="damage">火力</button>
        <button name="parameter" value="mobility">機動力</button>
        <button name="parameter" value="defense">防御力</button>
        <button name="parameter" value="burst">撃墜力</button>
        <button name="parameter" value="reversal">逆転力</button>
        <button name="parameter" value="neutral">立ち回り</button>
        <button name="parameter" value="edge">崖</button>
        <button name="parameter" value="recovery">復帰力</button>
        <button name="parameter" value="edgeguard">復帰阻止</button>
        <button name="parameter" value="easywin">処理性能</button>
        <button name="parameter" value="projectiles">飛び道具耐性</button>
        <button name="parameter" value="consistency">安定</button>
        <button name="parameter" value="difficulty">難易度</button>
        <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
    </form>
    <p>
        <?php
        foreach ($parameters as $en => $jp) {
            if ($_POST["parameter"] == $en) {
                echo $jp;
            }
        }
        ?>
        ランキング
    </p>
    <div class="container">
        <?php
        $i = 0;
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

            $i++;
            echo '<p>', $i, '位：', $jpname, '（', $votenum, '票）</p>';
            echo '<div class="result-area">
            <div class="chart-area">
                <canvas id="', $name, '">
                </canvas>
            </div>
            <img class="chara-image" src="../images/charaImages/', $name, '.png">
        </div>';
            if ($i >= 10) {
                break;
            }
        };
        ?>

        <form action="mypage.php" method="post">
            <button class="submit-button" type="submit" name="submit" id="submit">マイページへ</button>
            <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
        </form>

    </div>

    <script>
        function displayChart(id, datalist, mydatalist) {
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
                            label: "全体の結果",
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
                            data: datalist,
                        },
                        {
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
                            data: mydatalist,
                        }
                    ]
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
        let myresult = JSON.parse('<?php echo $myresult_json ?>');

        Object.keys(result).forEach(function(name) {
            var val = this[name]; // this は result
            var myval = myresult[name];
            displayChart(name, val, myval);
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