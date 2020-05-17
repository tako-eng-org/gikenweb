<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
    <!-- bootstrap header -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="../base.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>完了画面お問い合わせ | 技研ウェブ</title>
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