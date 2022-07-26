<?php

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="icon" type="image/png" href="../images/else/ssbu_characterVoting_icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>スマブラ投票権!!_マイページ</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <link rel="stylesheet" href="../csss/mypage.css">
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>

    <header>
        <h1>
            <a href="../login.php"><img class="header-image" src="../images/else/ssbu_characterVoting_icon.png" alt="スマブラ投票権!!"></a>
            スマブラ投票権!!
        </h1>

        <h1>
            ようこそ，<?php echo $_POST["username"]; ?>さん　
        </h1>
    </header>
</head>

<body>
    <div class="containter">
        <form action="" method="post" name="useraction" id="useraction">
            <button formaction="charaselect_vote.php" class="vote-button" type="submit" id="vote">投票する</button><br>
            <button formaction="charaselect_result.php" class="result-button" type="submit" id="result">結果を見る</button><br>
            <button formaction="myvote.php" class="myvote-button" type="submit" id="myvote">自分の投票</button>
            <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
        </form>
    </div>
</body>

<footer>
    <h1 class="footer-text">
        Respected
        <a href="https://www.smashbros.com/ja_JP/">大乱闘スマッシュブラザーズ</a>
    </h1>
</footer>

</html>