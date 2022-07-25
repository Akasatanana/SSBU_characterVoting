<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>SSBU_charaVoting</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">

    <link rel="stylesheet" href="../csss/charaselect.css">
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>
</head>

<header>
    <a href="username.php"><img src="../images/else/ssbu_characterVoting_icon.png" alt="スマブラ投票権!!"></a>
    <h1>スマブラ投票権!!</h1>
</header>

<body>
    <h1 class = "title-text">ファイターを選択</h1>
    <div class="imagezone">
            <form method="POST" action="voting.php">
                <?php
                $images = glob('../images/charaImages//*png');
                foreach ($images as $v) {
                    echo '<button type = "submit" name = "charaurl" value = "', $v, '" onclick = "location.href= "voting.php"" class = "nobordered_button">
                                    <img src="', $v, '" alt="" loading="lazy" class="image-vw">
                                </button>';
                }
                ?>
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