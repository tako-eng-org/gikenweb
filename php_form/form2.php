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
session_start();
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $subject = $_SESSION['subject'];
    $body = $_SESSION['body'];

    /*
    openssl_random_pseudo_bytes関数は、疑似乱数のバイト文字列を生成する関数です。
    base64_encode関数は、MIMEbase64方式でデータをエンコードする関数です。
    この２つの関数をつかうことで、$_SESSION['token']に、ランダムな文字列が代入されます。
    この文字列を、$token変数に代入して、hidden属性のinputタグの値にセットします。
    hidden属性なので、画面には表示されません。
    <formaction="form3.php"method="post">
    <inputtype="hidden"name="token"value="<?phpecho$token?>">
    formタグのaction属性をみるとform3.phpになっています。
    method属性はpostです。
    form3.phpの$_POSTにはtokenというキー名とランダムな文字列が値として渡されます。
    */
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(48));
    $token = htmlspecialchars($_SESSION['token'], ENT_QUOTES);
} ?><!doctypehtml>
    <html>

    <head>
        <meta charset="utf8">
        <title>確認画面お問い合わせ</title>
    </head>

    <body>
        <form action="form3.php" method="post">
            <table>
                <tr>
                    <th>お名前</th>
                    <td><?php echo $name; ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo $email; ?></td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td><?php echo $subject; ?></td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td><?php echo nl2br($body); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit" value="送信する"></td>
                </tr>
            </table>
            <input type="hidden" name="token" value="<?php echo $token ?>">
        </form>
        <!-- <ahref="form1.php?action=edit">はURLパラメータと呼ばれます。
            URLの後ろにデータをくっつけて、HTTPのGETメソッドでデータを送ることができます。
            actionは変数名、editが変数の値です。どちらも任意の文字列です。
            URLパラメータを使うと、別なページにデータを渡すことができます。
            URLパラメータの値は、$_GETというPHPが自動で生成する連想配列に自動で格納されます。
        form2.phpで、form1.php?action=editと書いていますので、$_GETには、actionというキーができ、値はeditが格納されています。
        if(isset($_GET['action'])&&$_GET['action']==='edit'){で、
            $_GETを調べて、actionキー名が存在して、なおかつactionキーの値がeditと等しければ、
            &&はtrueを返し、if文のブロックの内側の処理が実行されます。  -->
        <p><a href="form1.php?action=edit">入力画面へ戻る</a></p>
        
        </body>

<!-- フッタ -->
<div id="footer">
    <small>Copyright (c) 技研ウェブ All Rights Reserved.</small>
</div>
</div>
</body>

</html>