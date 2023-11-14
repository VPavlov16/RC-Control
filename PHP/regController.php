<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $rawPassword = $_POST["passw2"];

    $hashedPassword = hash('sha256', $rawPassword);

    $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    try {
        $stmt->execute();
        header("Location: ../Pages/index.php");
        exit();
       
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
   
    $conn = null;
}
?>
