<?php
header('Content-Type: application/json; charset=utf-8');

session_start();

$servername = "localhost";
$username = "xhrcan";
$password = "SQsBCnIEq5Vnxum";
$dbname = "zad3";

try{
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $stmt = $conn->prepare(
        "select
                    COUNT(google_id) as google,
                    (COUNT(id)-COUNT(google_id)) as classic
                    
                    from accounts");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $test = $stmt->fetchAll();

    echo json_encode($test);

} catch (PDOException $e){
    echo "<br>" . $e->getMessage();
}
