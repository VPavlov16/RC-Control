<?php
require "nav.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require('../PHP/mailerInfo.php');

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "admin";

$err = "none";
$sent = "none";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];


    $token = generateToken();

    $sql = "UPDATE users SET reset_token=:token WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['token' => $token, 'email' => $email]);

    if ($stmt->rowCount() > 0) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;               
            $mail->Username   = $uname;
            $mail->Password   = $pass;     
            $mail->SMTPSecure = 'tls';               
            $mail->Port       = 587; 
            $mail->setFrom($uname, 'RC-Control Team');
            $mail->addAddress($email);

            
            $mail->isHTML(true);
            $mail->Subject = 'Password reset';
            $mail->Body    = 'Чрез този линк можете да си смените паролата: <a href="http://localhost/DIplomna/RC-Control/Pages/resetpassword.php?token=' . $token . '">Reset Password</a>';

            $mail->send();
            $sent = 'block';
        } catch (Exception $e) {
            $err = 'block';
        }
    } else {
        $err = 'block';
    }
}


function generateToken() {
    return bin2hex(random_bytes(16)); 
}
?>

<!DOCTYPE html>
<html lang="bg" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Смяна на паролата</title>
    <link rel="stylesheet" href="../CSS/reg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <style>
    .sent {
      display: <?php echo $sent ?>;
      align: center;
    }
    .error {
      display: <?php echo $err ?>;
      align: center;
    }
    span{
      align: center;
    }
    </style>
</head>
<body>
<!-- Log -->
<div id="log" class="container">
    <div class="wrapper">
        <div class="title"><span>Смяна на паролата</span></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="row">
                <i class="fas fa-user"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <p class='sent'>Имейлът бе успешно изпратен!</p>
            <p class='error'>Не е намерен профил с дадения имейл!</p>
            <div class="row button">
                <input type="submit" value="Изпрати">
            </div>
        </form>
    </div>
</div>
</body>
</html>
