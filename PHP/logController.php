<?php
session_start(); 
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

if (!isset($_SESSION['info'])) {
    $_SESSION['info'] = "none";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["pass"];

    $hashedPassword = hash('sha256', $password);

    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user'] = [$user['id'], $user['email'],$user['info'],$user['emInfo']]; 
            $_SESSION['info'] = "none";
            session_regenerate_id(true);

            if (isset($_POST['remember_me'])) {
                $token = bin2hex(random_bytes(16));
                setcookie('remember_token', $token, time() + 604800,'/');
                setcookie('remember_email', $email, time() + 604800,'/');


                $sql2 = "UPDATE users SET token = :token WHERE email = :email";
    
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bindParam(':email', $email);
                $stmt2->bindParam(':token', $token);

                $stmt2->execute();
            }
            header("Location: ../Pages/index.php");
            exit();
        } else {
            $_SESSION['info'] = "flex";
            header("Location: ../Pages/register.php");
        }
    
    $conn = null;
}
?>
