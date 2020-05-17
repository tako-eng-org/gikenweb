<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
    <!-- bootstrap header -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="../base.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム | 技研ウェブ</title>
</head>

<!-- ul要素はUnorderd Listの略で、順序を問わないリストを作成する際に使用します。 li要素はリストの各項目を表します。 -->

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
            // echo "<pre>";
            // var_dump($_POST);
            // echo "</pre>";

            session_start();
            $errors = array();

            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $subject = $_POST['subject'];
                $body = $_POST['body'];
                /* htmlspecialchars関数は、&、<、>を'&amp;'、'&lt;'、'&gt;'に変換する関数
                ユーザーからの値を、HTMLに出力するときに、この関数をセキュリティ目的で使用します。
                この関数を通さないと、悪意あるプログラムコードをHTMLに注入されて、実行されてしまう危険性があります。
                */
                $name = htmlspecialchars($name, ENT_QUOTES);
                $email = htmlspecialchars($email, ENT_QUOTES);
                $subject = htmlspecialchars($subject, ENT_QUOTES);
                $body = htmlspecialchars($body, ENT_QUOTES);
                if ($name === "") {
                    $errors['name'] = "お名前が入力されていません。";
                }
                if ($email === "") {
                    $errors['email'] = "メールアドレスが入力されていません。";
                }
                if ($body === "") {
                    $errors['body'] = "お問い合わせ内容が入力されていません。";
                }

                /*
                count関数は、$errors連想配列のキーの数を数え、整数を返します。
                例えば、連想配列のキーが１つある場合は、１を返します。
                キーがまったくない連想配列の場合は、０を返します。
                count($errors)===0は、$errors連想配列のキーの数が整数型で値が0と等しければ、===はtrueを返します。
                $errors連想配列のキーの数が0ということは、空欄がないことを意味します。
                $_SESSIONは、PHPが実行時に自動で生成する連想配列です。
                ここにユーザーの入力データを格納しておくと、サーバー側で一時保存されます。
                $_SESSION['name']=$name;は、$_SESSION連想配列に、nameというキーをつくり、ユーザーが入力した名前のデータを格納しています。
                header('Location:http://localhost/php_form/form2.php');でform2.phpに画面遷移させています。
                */
                if (count($errors) === 0) {
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['subject'] = $subject;
                    $_SESSION['body'] = $body;
                    header('Location:form2.php');
                    exit();
                }
            }

            if (isset($_GET['action']) && $_GET['action'] === 'edit') {
                $name = $_SESSION['name'];
                $email = $_SESSION['email'];
                $subject = $_SESSION['subject'];
                $body = $_SESSION['body'];
            }

            //echo "<pre>";
            //var_dump($errors);
            //echo "</pre>";

            ?>
            <!doctypehtml>
                <html>

                <head>
                    <meta charset="utf8">
                    <title>お問い合わせ</title>
                </head>

                <body>
                    <a>お問い合わせフォームをphpとMySQLで実装します。</a>
                    <?php echo "<ul>";
                    foreach ($errors as $value) {
                        echo "<li>";
                        echo $value;
                        echo "</li>";
                    }
                    echo "</ul>";
                    ?>
                    <form action="form1.php" method="post">
                        <table>
                            <tr>
                                <th>お名前</th>
                                <!-- isset関数で、変数がセットされているかを、表示する前に確認する。これがないとNoticeエラー -->
                                <td><input type="text" name="name" value="<?php if (isset($name)) {
                                                                                echo $name;
                                                                            } ?>"></td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>
                                    <input type="text" name="email" value="<?php if (isset($email)) {
                                                                                echo $email;
                                                                            } ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>お問い合わせの種類</th>
                                <td><select name="subject">
                                        <option value="お仕事に関するお問い合わせ">お仕事に関するお問い合わせ</option>
                                        <option value="その他のお問い合わせ">その他のお問い合わせ</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <th>お問い合わせ内容</th>
                                <td><textarea name="body" cols="40" rows="10"><?php if (isset($body)) {
                                                                                    echo $body;
                                                                                } ?></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2"><input type="submit" name="submit" value="確認画面へ"></td>
                            </tr>
                        </table>
                    </form>
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