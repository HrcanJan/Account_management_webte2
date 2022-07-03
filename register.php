<?php

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

if(isset($_POST['name'])){
    try{
        require_once 'PHPGangsta/GoogleAuthenticator.php';

        $ga = new PHPGangsta_GoogleAuthenticator();

        $secret = $ga->createSecret();

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO users (name, email)
                                        VALUES (:name, :email)");
        $stmt->bindParam(":name", $_POST['name']);
        $stmt->bindParam(":email", $_POST['email']);
        $stmt->execute();

        $user_id = $conn->lastInsertId();

        $stmt = $conn->prepare("INSERT INTO accounts (user_id, type, password, secret)
                                        VALUES (".$user_id.", 'classic', :password, :secret)");
        $passwordHash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":secret", $secret);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO logins (account_id)
                                      VALUES (".$conn->lastInsertId().")");
        $stmt->execute();

        session_start();
        $_SESSION['name'] = $_POST['name'];
        header("Location: dashboard.php");
    } catch (PDOException $e){
        echo "<br>" . $e->getMessage();
    }

    $conn = null;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="fei.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
</head>
<body>

<form action="register.php" method="post">
    <div class="marginbottom">
        <label for="name">Name: </label>
        <input id="name" name="name" type="text">
    </div>
    <div class="marginbottom">
        <label for="email">Email: </label>
        <input id="email" name="email" type="email">
    </div>
    <div class="marginbottom">
        <label for="password">Password: </label>
        <input id="password" type="password" name="password">
    </div>
    <input type="submit" value="Register">

    <br><br><br><br>

    <div>
        <span>Už máš učet? <a href="index.php">Prihlás sa</a> </span>
    </div>
</form>


</body>
</html>