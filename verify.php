<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify</title>
    <link rel="icon" type="image/x-icon" href="fei.png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form action="create.php" method="post" class="normform">
    <label for="create">Paste the code here to verify 2fa activation: </label>
    <input id="create" name="create" type="text">
    <input type="submit">
</form>
</body>
</html>

<?php

require_once "PHPGangsta/GoogleAuthenticator.php";

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

$websiteTitle = 'Zad3';

$ga = new PHPGangsta_GoogleAuthenticator();

try {
    session_start();

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("select secret from accounts where id = :account");
    $stmt->bindParam(":account", $_SESSION['account']);
    $stmt->execute();
    $secret = $stmt->fetch();

    echo "secret: ".$secret['secret']."<br />";

    $qrCodeUrl = $ga->getQRCodeGoogleUrl($websiteTitle, $secret['secret']);
    echo 'Google Charts URL QR-Code:<br /><img src="'.$qrCodeUrl.'" />';

} catch (PDOException $e){
    echo "<br>" . $e->getMessage();
}

$conn = null;





