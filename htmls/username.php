<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">
    <link rel="stylesheet" href="../csss/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class = "username-containter">
        <h1 class = "username-headText">名前を入力してね</h1>
        <form method="get" action="charaSelect.php" target="_blank">
            <input class="username-textbox" type="text" name="username" autocomplete="off" maxlength="60">
            <button type = "submit"><i class="fa-solid fa-right"></i></button>
        </form>
    </div>
</body>
</html>