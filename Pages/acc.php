<?php
require "nav.php";

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "admin";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
try {
    $conn = new PDO($dsn);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

    $sql = "SELECT * FROM users WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id',$_SESSION['user'][0]);

    $stmt->execute();
    $info = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $conn = null;

?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/acc.css">
</head>
<body>

<div class="container">
    <h1 class="heading-1">My Account</h1>
    
    <label for="email">Email:</label>
    <?php echo"<p id='email' class='p-info'>".$info['email']."</p>"?>
    <br>
    </div>
</body>
</html>