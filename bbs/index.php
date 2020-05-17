<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
    <!-- bootstrap header -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="../base.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phpBBS | 技研ウェブ</title>
</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <!-- navbar-brand ... メインの項目 -->
        <a class="navbar-brand" href="../index.html">技研ウェブ</a>
    
        <!--  -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="navbarsExampleDefault">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarsExampleDefault" class="collapse navbar-collapse">
    
            <!-- navbar-nav ... ナビゲーション部分 -->
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                        <a class="nav-link" href="../index.html">ホーム</a>
                    </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../aboutme.html">自己紹介</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../portforio.html">ポートフォリオ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">工事中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contact.html">お問い合わせ</a>
                </li>
                <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="portforio.html" data-toggle="dropdown">Dropdown</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li> -->
            </ul>
            <!-- seach box -->
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-secondary my-2 my-sm-0" type="button">Search</button>
            </form>
        </div>
    </nav>

    <div id="pagebody">

        <!-- コンテンツ -->
        <div id="contents">
            <?php

            // var_dump(__LINE__); //debug********************************************
            $db_host = 'localhost';
            $db_user = 'board_user';
            $db_pass = 'board_pass';
            $db_name = 'board_db';

            // データベースへ接続する
            $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

            if (!$link) {
                // 直近の mysqli_connect() コールが失敗した場合、 エラーコードを返します。
                // ゼロは、何もエラーが発生しなかったことを示します。
                die('Connect Error: ' . mysqli_connect_errno());
            }

            if ($link !== false) {
                $msg     = '';
                $err_msg = '';

                if (isset($_POST['send']) === true) {

                    $name     = $_POST['name'];
                    $comment = $_POST['comment'];

                    if ($name !== '' && $comment !== '') {

                        $query = " INSERT INTO board ( "
                            . "    name , "
                            . "    comment "
                            . " ) VALUES ( "
                            . "'" . mysqli_real_escape_string($link, $name) . "', "
                            . "'" . mysqli_real_escape_string($link, $comment) . "'"
                            . " ) ";

                        $res   = mysqli_query($link, $query);

                        if ($res !== false) {
                            $msg = '書き込みに成功しました';
                        } else {
                            $err_msg = '書き込みに失敗しました';
                        }
                    } else {
                        $err_msg = '名前とコメントを記入してください';
                    }
                }

                $query  = "SELECT id, name, comment FROM board";
                $res    = mysqli_query($link, $query);
                $data = array();
                while ($row = mysqli_fetch_assoc($res)) {
                    array_push($data, $row);
                }
                arsort($data);
            } else {
                echo "データベースの接続に失敗しました";
            }

            // データベースへの接続を閉じる
            mysqli_close($link);
            ?>

            <html>

            <head>
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
            </head>

            <body>
                <form method="post" action="">
                    名前<input type="text" name="name" value="" />
                    コメント<textarea name="comment" rows="4" cols="20"></textarea>
                    <input type="submit" name="send" value="書き込む" />
                </form>
                <!-- ここに、書き込まれたデータを表示する -->
                <?php
                if ($msg     !== '') echo '<p>' . $msg . '</p>';
                if ($err_msg !== '') echo '<p style="color:#f00;">' . $err_msg . '</p>';
                foreach ($data as $key => $val) {
                    echo $val['name'] . ' ' . $val['comment'] . '<br>';
                }
                ?>
            </body>
        </div>
    </div>

    <!-- bootstrap start-->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <!-- bootstrap end-->

</body>

<!-- フッタ -->
<div id="footer">
    <small>Copyright (c) 技研ウェブ All Rights Reserved.</small>
</div>

</html>