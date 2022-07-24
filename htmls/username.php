<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
    <title>SSBU_charaVoting</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <link rel="stylesheet" href="../csss/usename_style.css">
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class = "username-containter1">
        <h1 class = "username-headText">名前とパスワードを入力</h1>
        <form method="post" action="" target="_blank">
                <div class = "usertype-select">
                    <input type="radio" name = "usertype" value = "new" checked> 新規ユーザ
                    <input type="radio" name = "usertype" value = "registered"> 登録済み<br>
                </div>
            <input class="username-textbox" type="text" name="username" placeholder="ユーザ名" autocomplete="off" maxlength="60"><br>
            <input class="username-textbox" type="text" name="password" placeholder="パスワード" autocomplete="off" maxlength="60"><br>
            <button class = "username-submit-button" type="submit">キャラ選択へ</button>

        </form>
    </div>
    <script>
        var existusername = JSON.parse(<?php echo $existsUsername_json ?>);
        if (existusername){
            alert("このユーザ名は既に登録されています");
        }else{
            alert("登録完了");
        }
    </script>
    <?php
    $existsUsername = false;
        if(isset($_POST["submit"])){
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

            if($_POST["usertype"] == "new"){

                $sql = "SELECT username FROM username WHERE username = ?";
                if ($result = $mysqli->prepare($sql)) {
                    $result->bind_param("s", $_POST['username']);
                    $result->execute();

                    $result->store_result(); // これ忘れるとnum_rowsは0
                    $rows = $result->num_rows;
                    if($rows == 0){
                        $stmt = $mysqli->prepare('INSERT INTO username (
                            username, paswword
                          ) VALUES (
                            ?, ?
                          )');
                        // (5)登録するデータをセット
                        $stmt->bind_param('ss', $_POST['username'], $_POST['password']);
                        // (6)登録実行
                        $stmt->execute();
                        $stmt->close();
                    }else{
                        $existsUsername = true;
                        $existsUsername_json = json_encode($existsUsername);
                    }
                }

            }else{

            }
        }
    ?>
</body>
</html>