<?php
session_start();
$_SESSION['info'] = "none";
$_SESSION['emInfo'] = "none";

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
    $_SESSION['emInfo'] = "none";
    $type = 'user';

    $hashedPassword = hash('sha256', $rawPassword);

    $checkEmailSql = "SELECT COUNT(*) FROM users WHERE email = :email";
    $checkEmailStmt = $conn->prepare($checkEmailSql);
    $checkEmailStmt->bindParam(':email', $email);
    $checkEmailStmt->execute();

    if ($checkEmailStmt->fetchColumn() > 0) {
        $_SESSION['emInfo'] = "flex";
        header("Location: ../Pages/register.php");
        exit();
    }

    $insertUserSql = "INSERT INTO users (email, password, type) VALUES (:email, :password, :type)";
    $insertUserStmt = $conn->prepare($insertUserSql);
    $insertUserStmt->bindParam(':email', $email);
    $insertUserStmt->bindParam(':password', $hashedPassword);
    $insertUserStmt->bindParam(':type', $type);

    try {
        $insertUserStmt->execute();
        header("Location: ../Pages/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
