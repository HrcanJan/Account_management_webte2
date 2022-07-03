<?php

session_start();

require_once 'PHPGangsta/GoogleAuthenticator.php';

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

if(isset($_POST['code'])) {

    $code = $_POST['code'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("select secret from accounts where id = :account");
        $stmt->bindParam(":account", $_SESSION['account']);
        $stmt->execute();
        $secret = $stmt->fetch();

        $ga = new PHPGangsta_GoogleAuthenticator();
        $result = $ga->verifyCode($secret['secret'], $code);


        if($result == 1)
            header("Location: dashboard.php");
        else
            header("Location: 2fa.php");

    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }
}