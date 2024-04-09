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
    $title = $_POST["title"];
    $desc = $_POST["description"];
    //$pict = $_POST["pic"];

    //pic 
    $file = $_FILES['pic'];
    $fileName = $file['name'];
    $fileTemp = $file['tmp_name'];

    $insertUserSql = "INSERT INTO vehicles (name, description, pic) VALUES (:name, :descript, :pic)";
    $insertUserStmt = $conn->prepare($insertUserSql);
    $insertUserStmt->bindParam(':name', $title);
    $insertUserStmt->bindParam(':descript', $desc);
    $insertUserStmt->bindParam(':pic', $fileName);

    copy($fileTemp, "../images/" .  $fileName);

    try {
        $insertUserStmt->execute();
        header("Location: ../Pages/vehicles.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Качване</title>
 <link rel="stylesheet" href="../CSS/panel.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
   <div class="panel">

   <p class="panel-title">Добавяне на устройство</p>

    <input type="text" name="title" maxlength="40" required placeholder="Име" class="txt-num">
    <input type="textarea" max="30" name="description" required  placeholder="Описание" class="txt-num">
    <label for="pic">Снимка</label>
    <input id="text" type="file" name="pic" value="pic" class="custom-input" required>
    <div class= "btn-div">
        <input type="submit" name="submit" value="Качване" class="send-btn">
        <a href="acc.php" class="cancel-btn"> Отказване </a>
    </div>      

   </div>
    </form>
    
    
</body>
</html>