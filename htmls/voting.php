<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/index.css">
</head>

<body>
    <strong class = "title2_font">キャラクターのパラメータを入力してね</strong>
    
    <?php
      $charaname =  explode(".", explode("/", $_POST["charaurl"])[3])[0];
      
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

    $sql = "SELECT * FROM characterName";
    if ($result = $mysqli->query($sql)) {
        // 連想配列を取得
        while ($row = $result->fetch_assoc()) {
            echo $row["id"] . $row["name"] . "<br>";
        }
        // 結果セットを閉じる
        $result->close();
    }


      $mysqli->close();
    ?>
</body>
</html>