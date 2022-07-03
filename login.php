<?php

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

if(isset($_POST['email'])){
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("select 
                                            name, 
                                            password, 
                                            user_id, 
                                            accounts.id as account from users
                                            join accounts on users.id = accounts.user_id
                                            where email = :email
                                            and `type` = 'classic'");
        $stmt->bindParam(":email", $_POST['email']);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetch();

        if(password_verify($_POST['password'], $user['password'])){
            $stmt = $conn->prepare("INSERT INTO logins (account_id)
                                            VALUES(".$user["account"].")");
            $stmt->execute();
            session_start();
            $_SESSION['name'] = $user['name'];
            $_SESSION['account'] = $user['account'];
            header("Location: 2fa.php");
        }
    } catch (PDOException $e){
        echo "<br>" . $e->getMessage();
    }

    $conn = null;
}