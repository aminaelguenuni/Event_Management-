<?php

$host   = 'localhost';

$dbname = 'team01db';

$user   = 'team01';

$pass   = 'password';

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Connection failed: " . $e->getMessage());

}

?>
