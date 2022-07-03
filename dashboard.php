<?php
session_start();

if(!isset($_SESSION['name'])){
    header("Location: index.php");
}
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
    <title>Welcome</title>
</head>
<body>

<form class="normform">
    <button class="right" formaction="logout.php">Logout</button>
    You are logged in! <?php echo $_SESSION['name']; ?>
</form>

<form class="normform">
    <button formaction="verify.php">Activate 2fa</button>
</form>

<br><br>

<button id="but" onclick="changeForm()">Statistics</button>

<div id="statistics">
    <div class="grid">
        <table id="table">
            <thead>
            <tr>
                <th>Prihlásenie</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

        <table id="table2">
            <thead>
            <tr>
                <th>Prihlásených cez google</th>
                <th>Prihlásených na klasický spôsob</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
