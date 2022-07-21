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
      $db_host = 'localhost';
      $db_user = 'root';
      $db_password = 'root';
      $db_db = 'information_schema';
    
      $mysqli = @new mysqli(
        $db_host,
        $db_user,
        $db_password,
        $db_db
      );
      $mysqli->close();
      $charaname =  explode(".", explode("/", $_POST["charaurl"])[3])[0];
      echo $charaname;
    ?>
</body>
</html>