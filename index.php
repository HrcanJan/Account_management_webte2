<?php
require_once  'vendor/autoload.php';

$client = new Google\Client();
$client->setAuthConfig('client_secret_918954158640-hma4squ20kjvq6infffrpsck9g5ichir.apps.googleusercontent.com.json');
$redirect_uri = 'https://site76.webte.fei.stuba.sk/zad3b/redirect.php';
$client->addScope("email");
$client->addScope("profile");
$client->setRedirectUri($redirect_uri);
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
    <title>Registration form</title>
</head>
<body>

<form action="login.php" method="post">
    <div class="marginbottom">
        <label for="email">Email: </label>
        <input id="email" name="email" type="email">
    </div>
    <div class="marginbottom">
        <label for="password">Password: </label>
        <input id="password" type="password" name="password">
    </div>
    <input class="marginbottom" type="submit" value="Login">
    <?php
    echo "<a href='".$client->createAuthUrl()."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Google Login</a>";
    ?>
    <br><br><br><br>

    <div class="marginbottom">
        <span>Nemaš ešte učet? <a href="register.php">Zaregistruj sa</a> </span>
    </div>

</form>

</body>
</html>
