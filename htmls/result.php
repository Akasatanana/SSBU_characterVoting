<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/index.css">
</head>

<body>
    <strong class = "title2_font">投稿ありがとう！</strong>
    
    <?php
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = 'root';
        $db_db = 'SSBU_charaVoting';
    
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

        // (4)プリペアドステートメントの用意
        $stmt = $mysqli->prepare('INSERT INTO characterVoting (
            charaname, damage, mobility, returnability, burstability, breakability, copability, resistanceForCS, popularity
          ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?
          )');
        // (5)登録するデータをセット
        $stmt->bind_param('siiiiiiii', $_POST['charaname'], $_POST['damage'], $_POST['mobility'], $_POST['returnability'], $_POST['burstability'], $_POST['breakability'], $_POST['copability'], $_POST['resistanceForCS'], $_POST['popularity']);
        // (6)登録実行
        $stmt->execute();
        $stmt->close();

        $sql = "SELECT damage, mobility, returnability, burstability, breakability, copability, resistanceForCS, popularity FROM characterVoting WHERE charaname = ?";
        if ($result = $mysqli->prepare($sql)) {
            $result->bind_param("s", $_POST['charaname']);
            $result->execute();

            $result->store_result(); // これ忘れるとnum_rowsは0
            $rows = $result->num_rows;
            $resultlist = array(0, 0, 0, 0, 0, 0, 0, 0);
            $result->bind_result($resultlist[0], $resultlist[1], $resultlist[2], $resultlist[3], $resultlist[4], $resultlist[5], $resultlist[6], $resultlist[7]);

            $avelist = array(0, 0, 0, 0, 0, 0, 0, 0);

            while ($result->fetch()) {
                for($i = 0; $i < count($resultlist); $i++){
                    $avelist[$i] += $resultlist[$i];
                }
            }
            $result->close();

            echo "<br>";
            for($i = 0; $i < count($resultlist); $i++){
                $avelist[$i] /= $rows;
                echo "$avelist[$i] ";
            }
            echo "<br>";
        }
    ?>
</body>
</html>