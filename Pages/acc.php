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
    
    if ($info['type'] == "admin") {
        $buttonDisplay = "inline-block";
    } else {
        $buttonDisplay = "none";
    }

    $conn = null;

?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профил</title>
    <link rel="stylesheet" href="../CSS/acc.css">
    <style>
        .admin{
            display: <?php echo $buttonDisplay; ?>;
        }
        
    </style>
</head>
<body>

<div class="container">
    <h1 class="heading-1">Моят профил</h1>
    
    <label for="email">Имейл:</label>
    <?php echo"<p id='email' class='p-info'>".$info['email']."</p>"?>
    <br>
    <label for="mins">Налични минути:</label>
    <?php echo"<p id='mins' class='p-info'>".$info['minutes']."</p>"?>
    <br>
    <button onclick="window.location.href='adminPanel.php';" class="button admin">Добавяне на устройство</button>      
    <br>
    <button class="button" onclick=logout()>Излизане</button>
    </div>
</body>
<script>
function logout() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.location.href = 'index.php';
        }
    };
    xhttp.open("GET", "../PHP/logout.php", true);
    xhttp.send();
}
</script>
</html>