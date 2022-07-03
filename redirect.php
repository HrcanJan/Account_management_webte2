<?php

require_once 'vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig('client_secret_918954158640-hma4squ20kjvq6infffrpsck9g5ichir.apps.googleusercontent.com.json');

if(isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    $client->setAccessToken($token['access_token']);

    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;
    $id = $google_account_info->getId();

    $servername = "localhost";
    $username = "xhrcan";
    $password = "SQsBCnIEq5Vnxum";
    $dbname = "zad3";

    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT email from users");
        $stmt->execute();
        $user = $stmt->fetchAll();

        foreach($user as $item){
            if($item['email'] == $email) {
                $stmt = $conn->prepare("select 
                                        name, 
                                        password, 
                                        user_id, 
                                        accounts.id as account from users
                                        join accounts on users.id = accounts.user_id
                                        where email = :email
                                        and `type` = 'google'");
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $user = $stmt->fetch();

                session_start();
                $_SESSION['name'] = $name;
                $_SESSION['account'] = $user['account'];
                header("Location: 2fa.php");
            }
        }


} catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
}

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("INSERT INTO users(name, email)
                                        VALUES (:name, :email)");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();

        $user_id = $conn->lastInsertId();

        require_once 'PHPGangsta/GoogleAuthenticator.php';

        $ga = new PHPGangsta_GoogleAuthenticator();

        $secret = $ga->createSecret();

        $stmt = $conn->prepare("INSERT INTO accounts (user_id, type, google_id, secret)
                                        VALUES (".$user_id.", 'google', '".$id."', :secret)");
        $stmt->bindParam(":secret", $secret);
        $stmt->execute();



        $stmt = $conn->prepare("INSERT INTO logins(account_id)
                                        VALUES (".$conn->lastInsertId().")");
        $stmt->execute();

        $stmt = $conn->prepare("select 
                                        name, 
                                        password, 
                                        user_id, 
                                        accounts.id as account from users
                                        join accounts on users.id = accounts.user_id
                                        where email = :email
                                        and `type` = 'google'");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetch();

        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['account'] = $user['account'];
        header("Location: 2fa.php");
    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }

    $conn = null;
}
