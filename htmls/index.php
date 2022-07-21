<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/index.css">
</head>

<body>
    <strong class = "title2_font">投票するキャラクターを選択してね</strong>
    <div class="imagezone">
        <form method="POST" action="voting.php">
            <?php
                $images = glob('../charaImages//*jpg');
                foreach($images as $v) {
                    echo '<button type = "submit" name = "charaurl" value = "' , $v , '" onclick = "location.href= "voting.php"" class = "nobordered_button">
                            <img src="' , $v , '" alt="" loading="lazy" class="image-vw">
                        </button>';
                }
            ?>
        </form>
    </div>
</body>
</html>