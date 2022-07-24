
<?php
    $existsUsername = false;
    $notexistUsername = false;
    $incorrectPassword = false;

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

    if ($_POST["usertype"] == "new") {
        echo "here<br>";//デバッグ用
        $sql = "SELECT name FROM username WHERE name = ?";
        if ($result = $mysqli->prepare($sql)) {
            echo "here<br>";//デバッグ用
            $result->bind_param("s", $_POST['username']);
            $result->execute();

            $result->store_result(); // これ忘れるとnum_rowsは0
            $rows = $result->num_rows;
            if ($rows == 0) {
                echo "here<br>";//デバッグ用
                $stmt = $mysqli->prepare('INSERT INTO username (
                            username, password
                          ) VALUES (
                            ?, ?
                          )');
                // (5)登録するデータをセット
                $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
                // (6)登録実行
                $stmt->execute();
                $stmt->close();
            } else {
                echo "here<br>";//デバッグ用
                $existsUsername = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/style.css">
</head>

<body>
    <?php 
        echo $existsUsername."<br>";
        echo $_POST["username"]."<br>";
        echo $_POST["password"]."<br>";
    ?>
</body>
</html>