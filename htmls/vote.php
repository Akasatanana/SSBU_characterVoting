<!DOCTYPE html>
<html lang="ja">

<head>
    <link rel="icon" type="image/png" href="../images/else/ssbu_characterVoting_icon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title>スマブラ投票権!!_投票</title>
    <!--cssの初期化用，必ず先頭に-->
    <link rel="stylesheet" href="https://unpkg.com/destyle.css@3.0.2/destyle.min.css">

    <link rel="stylesheet" href="../csss/vote.css">
    <!--googlefonts用-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kosugi&display=swap" rel="stylesheet">
    <!--fontawesome用-->
    <script src="https://kit.fontawesome.com/e435c5f384.js" crossorigin="anonymous"></script>
</head>

<header>
    <h1>
        <a href="../login.php"><img class="header-image" src="../images/else/ssbu_characterVoting_icon.png" alt="スマブラ投票権!!"></a>
        スマブラ投票権!!
    </h1>

    <h1>
        ようこそ，<?php echo $_POST["username"]; ?>さん　
    </h1>
</header>

<body>
    <p>評価項目を貴方なりに解釈し，数値を入力してください．<br>
    各ファイターへの投票は一人一票までです．
    </p>
    <form id="vote" method="POST" , action="result.php">
        <div class="container">
            <img class="chara-image" src=<?php echo $_POST["charaurl"]; ?>><br>
            <p class="explaination-text">　各項目に関して，ファイターに対するあなたの評価値を入力してください.</p>
            <hr>
            <div class="input-area">
                <h1>1.火力</h1>
                <input id="damage-range" type="range" name="damage" min="1" max="10" step="1" value="5"><br>
                <h2><span id="damage-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('damage-range');
                    var target = document.getElementById('damage-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>2.機動力</h1>
                <input id="mobility-range" type="range" name="mobility" min="1" max="10" step="1" value="5"><br>
                <h2><span id="mobility-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('mobility-range');
                    var target = document.getElementById('mobility-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>3.防御力</h1>
                <input id="defense-range" type="range" name="defense" min="1" max="10" step="1" value="5"><br>
                <h2><span id="defense-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('defense-range');
                    var target = document.getElementById('defense-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>4.撃墜力</h1>
                <input id="burst-range" type="range" name="burst" min="1" max="10" step="1" value="5"><br>
                <h2><span id="burst-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('burst-range');
                    var target = document.getElementById('burst-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>5.逆転力</h1>
                <input id="reversal-range" type="range" name="reversal" min="1" max="10" step="1" value="5"><br>
                <h2><span id="reversal-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('reversal-range');
                    var target = document.getElementById('reversal-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>6.立ち回りの強さ</h1>
                <input id="neutral-range" type="range" name="neutral" min="1" max="10" step="1" value="5"><br>
                <h2><span id="neutral-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('neutral-range');
                    var target = document.getElementById('neutral-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>


            <hr>
            <div class="input-area">
                <h1>7.崖の強さ</h1>
                <input id="edge-range" type="range" name="edge" min="1" max="10" step="1" value="5"><br>
                <h2><span id="edge-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('edge-range');
                    var target = document.getElementById('edge-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <div class="input-area">
                <h1>8.復帰力</h1>
                <input id="recovery-range" type="range" name="recovery" min="1" max="10" step="1" value="5"><br>
                <h2><span id="recovery-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('recovery-range');
                    var target = document.getElementById('recovery-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <div class="input-area">
                <h1>9.復帰阻止の強さ</h1>
                <input id="edgeguard-range" type="range" name="edgeguard" min="1" max="10" step="1" value="5"><br>
                <h2><span id="edgeguard-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('edgeguard-range');
                    var target = document.getElementById('edgeguard-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <div class="input-area">
                <h1>10.処理性能</h1>
                <input id="easywin-range" type="range" name="easywin" min="1" max="10" step="1" value="5"><br>
                <h2><span id="easywin-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('easywin-range');
                    var target = document.getElementById('easywin-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>11.飛び道具への強さ</h1>
                <input id="projectiles-range" type="range" name="projectiles" min="1" max="10" step="1" value="5"><br>
                <h2><span id="projectiles-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('projectiles-range');
                    var target = document.getElementById('projectiles-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>12.安定のしやすさ</h1>
                <input id="consistency-range" type="range" name="consistency" min="1" max="10" step="1" value="5"><br>
                <h2><span id="consistency-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('consistency-range');
                    var target = document.getElementById('consistency-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>

            <hr>
            <div class="input-area">
                <h1>13.難易度(難しいほど低い数値)</h1>
                <input id="difficulty-range" type="range" name="difficulty" min="1" max="10" step="1" value="5"><br>
                <h2><span id="difficulty-value">5</span>/10</h2>
                <script>
                    var elem = document.getElementById('difficulty-range');
                    var target = document.getElementById('difficulty-value');
                    var rangeValue = function(elem, target) {
                        return function(evt) {
                            target.innerHTML = elem.value;
                        }
                    }
                    elem.addEventListener('input', rangeValue(elem, target));
                </script>
            </div>
        </div>

        <input class="submit-button" type="submit" name="send" value="投票">
        <input type="hidden" name="username" value='<?php echo $_POST["username"]; ?>'>
        <input type="hidden" name="charaurl" value='<?php echo $_POST["charaurl"]; ?>'>
        <input type="hidden" name="select-style" value='vote'>
    </form>
</body>

<footer>
    <h1 class="footer-text">
        Respected
        <a href="https://www.smashbros.com/ja_JP/">大乱闘スマッシュブラザーズ</a>
    </h1>
</footer>

</html>