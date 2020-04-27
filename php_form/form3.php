<?php
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

    $dsn = 'mysql:dbname=contact_form;host=localhost;charset=utf8mb4';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    // var_dump($dbh->errorInfo()); //PDOを使っているとき
    var_dump(__LINE__); //**********debug
    var_dump($dbh);

    $dbh > query('SET NAMES utf8');
    $dbh > setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = 'INSERT INTO inquiries (name,email,subject,body) VALUES( ?, ?, ?, ?)';
    $stmt = $dbh > prepare($sql);

    $stmt > bindValue(1, $name, PDO::PARAM_STR);
    $stmt > bindValue(2, $email, PDO::PARAM_STR);
    $stmt > bindValue(3, $subject, PDO::PARAM_STR);
    $stmt > bindValue(4, $body, PDO::PARAM_STR);
    
    $stmt > execute();
    
    $dbh=null;
    
    echo "きちんとしたアクセスです";

} else {
    echo "不正なアクセス";
    header('Location:form1.php');exit();
}   
?>

    <!doctypehtml>
    <html>

    <head>
        <meta charset="utf8">
        <title>完了画面お問い合わせ</title>
    </head>

    <body>
        <p>お問い合わせありがとうございます。</p>
    </body>

    </html>
