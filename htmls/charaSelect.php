<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>SSBU_charaVoting</title>
    <link rel="stylesheet" href="../csss/style.css">
</head>

<body>
    <strong class = "title2_font">キャラクターを選択してね</strong>
    <div class="imagezone">
        <form method="POST" action="voting.php">
            <?php
                $images = glob('../charaImages//*png');
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