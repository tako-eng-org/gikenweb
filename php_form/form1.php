<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../base.css">
    <title>ホーム | 技研ウェブ</title>
</head>

<!-- ul要素はUnorderd Listの略で、順序を問わないリストを作成する際に使用します。 li要素はリストの各項目を表します。 -->

<body>
    <div id="pagebody">

        <!-- ヘッダ -->
        <div id="header">
            <h1><a href="../index.html">技研ウェブ</a></h1>
        </div>

        <!-- メインメニュー -->
        <ul id="menu">
            <li><a href="../index.html">ホーム</a></li>
            <li><a href="../aboutme.html">自己紹介</a></li>
            <li><a href="../portforio.html">ポートフォリオ</a></li>
            <li><a href="../contact.html">お問い合わせ</a></li>
        </ul>

        <!-- ***************** メインメニュー ***************** -->
        <!-- アプリメニュー -->
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

<!-- フッタ -->
<div id="footer">
    <small>Copyright (c) 技研ウェブ All Rights Reserved.</small>
</div>
</div>
</body>

</html>