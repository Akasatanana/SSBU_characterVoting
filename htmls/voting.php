<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/index.css">
</head>

<body>
    <strong class = "title2_font">キャラクターのパラメータを入力してね</strong>
    <form method="POST", action = "result.php">
      火力：<input type="number" name="damage" min="0" max="10"><br>
      機動力：<input type="number" name="mobility" min="0" max="10"><br>
      復帰力：<input type="number" name="returnability" min="0" max="10"><br>
      撃墜力：<input type="number" name="burstability" min="0" max="10"><br>
      壊し性能：<input type="number" name="breakability" min="0" max="10"><br>
      立ち回り：<input type="number" name="copability" min="0" max="10"><br>
      飛び道具耐性：<input type="number" name="resistanceForCS" min="0" max="10"><br>
      人気：<input type="number" name="popularity" min="0" max="10"><br>
      <input type = "text", name = "charaname" value = "<?php echo explode(".", explode("/", $_POST['charaurl'])[3])[0]; ?>">
      <input type="submit" name="send" value="送信">
    </form>
</body>
</html>