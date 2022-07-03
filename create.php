<?php

require_once "PHPGangsta/GoogleAuthenticator.php";

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

if(isset($_POST['create'])) {
    $code = $_POST['create'];

    session_start();

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("select secret from accounts where id = :account");
    $stmt->bindParam(":account", $_SESSION['account']);
    $stmt->execute();
    $secret = $stmt->fetch();

    $ga = new PHPGangsta_GoogleAuthenticator();
    $result = $ga->verifyCode($secret['secret'], $code);

    if ($result == 1)
        {

            try{
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("UPDATE accounts
                                        SET 2fa = :2fa
                                        WHERE id = :account");
                $stmt->bindParam(":account", $_SESSION['account']);
                $stmt->bindParam(":2fa", $result);
                $stmt->execute();

                header("Location: dashboard.php");
            } catch (PDOException $e){
                echo "<br>" . $e->getMessage();
            }

            $conn = null;
        }
    else
        echo 'Login failed';
}