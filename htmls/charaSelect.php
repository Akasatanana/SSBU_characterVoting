
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
        $sql = "SELECT name FROM username WHERE name = ?";
        if ($result = $mysqli->prepare($sql)) {
            $result->bind_param("s", $_POST['username']);
            $result->execute();

            $result->store_result(); // これ忘れるとnum_rowsは0
            $rows = $result->num_rows;
            if ($rows == 0) {
                $stmt = $mysqli->prepare('INSERT INTO username (
                            name, password
                          ) VALUES (
                            ?, ?
                          )');
                // (5)登録するデータをセット
                $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
                // (6)登録実行
                $stmt->execute();
                $stmt->close();
            } else {
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
    <?php if($existsUsername){ ?> <!--新規ユーザで登録不可能-->
        <strong class = "title2_font">このユーザ名は既に登録されています</strong>
    <?php }else{ ?><!--正常な処理-->
        <strong class = "title2_font">キャラクターを選択してね</strong>
        <div class="imagezone">
            <form method="POST" action="voting.php">
                <?php
                    $images = glob('../images/charaImages//*png');
                    foreach($images as $v) {
                        echo '<button type = "submit" name = "charaurl" value = "' , $v , '" onclick = "location.href= "voting.php"" class = "nobordered_button">
                                <img src="' , $v , '" alt="" loading="lazy" class="image-vw">
                            </button>';
                    }
                ?>
            </form>
        </div>
    <?php } ?>
</body>
</html>