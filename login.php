<?php
$_POST["usererrorType"];
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

if (isset($_POST["confirm"])) {
    /*
    useerrortype = -1->正常
    useerrortype = 1->新規：ユーザ名が登録済み
    useerrortype = 2->既存：ユーザ名が未登録
    useerrortype = 3->既存：パスワードが異なる
    */

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

                $_POST["usererrorType"] = -1;
            } else {
                $_POST["usererrorType"] = 1;
            }
        }
    } else {
        $sql = "SELECT name, password FROM username WHERE name = ?";
        if ($result = $mysqli->prepare($sql)) {
            $result->bind_param("s", $_POST['username']);
            $result->execute();

            $result->store_result(); // これ忘れるとnum_rowsは0
            $rows = $result->num_rows;
            if ($rows == 0) {
                $_POST["usererrorType"] = 2;
            } else {
                $resultlist = array("", "");
                $result->bind_result($resultlist[0], $resultlist[1]);

                while ($result->fetch()) {
                    for ($i = 0; $i < count($resultlist); $i++) {
                        if ($resultlist[1] != $_POST["password"]) {
                            $incorrectPassword = true;
                            break;
                        }
                    }
                }
                $result->close();

                if ($incorrectPassword) {
                    $_POST["usererrorType"] = 3;
                } else {
                    $_POST["usererrorType"] = -1;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="icon" type="image/png" href="images/else/ssbu_characterVoting_icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>スマブラ投票権!!_ログイン</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <link rel="stylesheet" href="csss/standard-content.css">
    <link rel="stylesheet" href="csss/login.css">
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>

    <header>
        <h1>
            <a href="login.php"><img class="header-image" src="images/else/ssbu_characterVoting_icon.png" alt="スマブラ投票権!!"></a>
            スマブラ投票権!!
        </h1>
    </header>
</head>

<body>
    <div class="username-containter1">
        <h1 class="username-headText">名前とパスワードを入力</h1>
        <p>
            <?php
            switch ($_POST["usererrorType"]) {
                case -1:
                    echo "認証されました！";
                    break;
                case 1:
                    echo "このユーザ名は登録済みです．";
                    break;
                case 2:
                    echo "このユーザ名は未登録です．";
                    break;
                case 3:
                    echo "パスワードが違います．";
                    break;
            }
            ?>
        </p><br>
        <form action="" method="post" name="userdata" id="formId">
            <div class="usertype-select">
                <input id="new" type="radio" name="usertype" value="new" required> 新規ユーザ
                <input id="registerd" type="radio" name="usertype" value="registered"> 登録済み<br>
            </div>
            <input id="name" class="username-textbox" type="text" name="username" placeholder="ユーザ名" autocomplete="off" maxlength="60" required><br>
            <input id="password" class="username-textbox" type="password" name="password" placeholder="パスワード" autocomplete="off" maxlength="60" required><br>
            <button class="username-confirm-button" type="submit" name="confirm" id="confirm">認証</button><br>
            <button class="username-submit-button" type="submit" name="submit" id="submit" style="display: none">マイページへ</button>
            <input type="hidden" name="usererrorType" value=0>

        </form>
    </div>

    <script type="text/javascript">
        if (<?php echo isset($_POST["usererrorType"]); ?> && <?php echo $_POST["usererrorType"]; ?> == -1) {
            document.userdata.action = "htmls/mypage.php";
            document.getElementById('confirm').style.display = 'none';
            document.getElementById('submit').style.display = 'inline';

            document.getElementById('name').value = "<?php echo $_POST["username"]; ?>";
            document.getElementById('password').value = "<?php echo $_POST["password"]; ?>";

            let elements = document.getElementsByName('usertype');
            let len = elements.length;

            for (let i = 0; i < len; i++) {
                if (elements.item(i).value == "<?php echo $_POST["usertype"]; ?>") {
                    elements[i].checked = true;
                }
            }
            document.getElementById('name').readOnly = true;
            document.getElementById('password').readOnly = true;
            for (let i = 0; i < len; i++) {
                elements[i].disabled = true;
            }
        }
    </script>
</body>

<footer>
    <h1 class="footer-text">
        Respected
        <a href="https://www.smashbros.com/ja_JP/">大乱闘スマッシュブラザーズ</a>
    </h1>
</footer>

</html>