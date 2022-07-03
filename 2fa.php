<?php
session_start();

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT 2fa from accounts where id = :account");
    $stmt->bindParam(":account", $_SESSION['account']);
    $stmt->execute();
    $fa = $stmt->fetch();

    //var_dump($_SESSION['account']);

    if($fa['2fa'] == null){
        header("Location: dashboard.php");
    }

} catch (PDOException $e){
    echo "<br>" . $e->getMessage();
}

 $conn = null;

?>

<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="fei.png">
    <link rel="stylesheet" href="css/style.css">
    <title>2fa verification</title>
</head>
<body>

<form class="normform" action="check.php" method="post">
    <div>
        <label for="code">Enter 2fa Code here: </label>
        <input type="number" id="code" name="code">
    </div>
    <input type="submit" value="Submit">
</form>

</body>
</html>
