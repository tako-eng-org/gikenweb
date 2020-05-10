<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../base.css">
    <title>完了画面お問い合わせ | 技研ウェブ</title>
</head>

<body>
    <div id="pagebody">

        <!-- ヘッダ(ホーム) -->
        <div id="header">
            <h1><a href="index.html">技研ウェブ</a></h1>
        </div>

        <!-- メニュー -->
        <ul id="menu">
            <li><a href="../index.html">ホーム</a></li>
            <li><a href="../aboutme.html">自己紹介</a></li>
            <li><a href="../portforio.html">ポートフォリオ</a></li>
            <li><a href="../contact.html">お問い合わせ</a></li>
        </ul>

        <!-- コンテンツ -->
        <div id="contents">
            <?php
            ini_set("display_errors", 1);
            error_reporting(E_ALL);

            session_start();

            //echo "<pre>";
            //var_dump($_POST, $_SESSION);
            //echo "</pre>";
            //die();

            var_dump(__LINE__);

            if (isset($_POST['token'], $_SESSION['token']) && ($_POST['token'] === $_SESSION['token'])) {
                unset($_SESSION['token']);
                var_dump(__LINE__); //**********debug
                $name = $_SESSION['name'];
                $email = $_SESSION['email'];
                $subject = $_SESSION['subject'];
                $body = $_SESSION['body'];

                try {
                    $dsn = 'mysql:dbname=contact_form;host=localhost;charset=utf8mb4';
                    $user = 'root';
                    $password = '';
                    var_dump(__LINE__); //**********debug
                    $dbh = new PDO($dsn, $user, $password);
                    var_dump(__LINE__); //**********debug
                    var_dump(__LINE__); //**********debug
                    // var_dump($dbh->errorInfo()); //PDOを使っているとき
                    var_dump(__LINE__); //**********debug
                    var_dump($dbh);
                    //$dbh > query('SET NAMES utf8');
                    $dbh > setAttribute(
                        PDO::ATTR_EMULATE_PREPARES,
                        false
                    );
                    $sql = 'INSERT INTO inquiries (name,email,subject,body) VALUES( ?, ?, ?, ?)';
                    $stmt = $dbh > prepare($sql);

                    $stmt > bindValue(1, $name, PDO::PARAM_STR);
                    $stmt > bindValue(2, $email, PDO::PARAM_STR);
                    $stmt > bindValue(3, $subject, PDO::PARAM_STR);
                    $stmt > bindValue(4, $body, PDO::PARAM_STR);

                    $stmt > execute();

                    $dbh = null;

                    echo "きちんとしたアクセスです";
                } catch (PDOException $Exception) {
                    die('接続エラー：' . $Exception->getMessage());
                    var_dump(__LINE__); //**********debug
                }
            } else {
                echo "不正なアクセス";
                header('Location:form1.php');
                exit();
            }
            ?>

            <p>お問い合わせありがとうございます。</p>

        </div>
    </div>
</body>

<!-- フッタ -->
<div id="footer">
    <small>Copyright (c) 技研ウェブ All Rights Reserved.</small>
</div>

</html>