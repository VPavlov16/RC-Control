<?php
require "nav.php";

if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: index.php");
    exit;
}

$token = $_GET['token'];

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "admin";

$err1 = 'none';
$err2 = 'none';
try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password != $confirmPassword) {
        $err1 = "display-block";
    } else {
        $hashedPassword = hash('sha256', $password);

        $sql = "UPDATE users SET password=:password, reset_token=NULL WHERE reset_token=:token";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['password' => $hashedPassword, 'token' => $token]);


        if ($stmt->rowCount() > 0) {
            header("Location: index.php");
            exit;
        } else {
            $err2 = "display-block";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="bg" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../CSS/reg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    .err1 {
      display: <?php echo $err1 ?>;
      align: center;
    }
    .err2 {
      display: <?php echo $err2 ?>;
      align: center;
    }
    span{
      align: center;
    }
    </style>
</head>
<body>
<div class="container">
    <div class="wrapper">
        <div class="title"><span>Смяна на парола</span></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?token=' . $token; ?>" method="POST">
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Нова парола" required>
            </div>
            <div class="row">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Потвърдете паролата" required>
            </div>
            <p class='err1'>Паролите не съвпадат</p>
            <p class='err2'>Изникна грешка при промяната на паролата!</p>
            <div class="row button">
                <input type="submit" value="Смяна на паролата">
            </div>
        </form>
        <?php if (isset($errorMessage)) : ?>
            <div class="error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
