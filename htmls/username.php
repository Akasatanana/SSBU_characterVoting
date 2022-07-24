<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
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
    <div class="username-containter1">
        <h1 class="username-headText">名前とパスワードを入力</h1>
        <form method="post" action="charaSelect.php" target="_blank">
            <div class="usertype-select">
                <input type="radio" name="usertype" value="new" checked> 新規ユーザ
                <input type="radio" name="usertype" value="registered"> 登録済み<br>
            </div>
            <input class="username-textbox" type="text" name="username" placeholder="ユーザ名" autocomplete="off" maxlength="60"><br>
            <input class="username-textbox" type="text" name="password" placeholder="パスワード" autocomplete="off" maxlength="60"><br>
            <button class="username-submit-button" type="submit">キャラ選択へ</button>

        </form>
    </div>
</body>

</html>