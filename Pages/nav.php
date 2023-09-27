<?php
$current_url = $_SERVER['REQUEST_URI'];
$filename = basename($current_url);
$homeatr = "";
$vehatr = "";
$conatr = "";
$regatr = "";

if($filename == "index.php"){
    $homeatr = "active";
}elseif($filename == "vehicles.php"){
    $vehatr = "active";
}elseif($filename == "contactus.php"){
    $conatr = "active";
}elseif($filename == "register.php"){
    $regatr = "active";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RC Control</title>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
</head>
<body>
    <nav class="nav nav-pills nav-justified">
        <a class="nav-link <?php echo $homeatr ?> navitem " href="index.php">Home</a>
        <a class="nav-link <?php echo $vehatr ?> navitem " href="vehicles.php">Vehicles</a>
        <a class="nav-link <?php echo $conatr ?> navitem " href="contactus.php">Contact</a>
        <a class="nav-link <?php echo $regatr ?> navitem " href="register.php">Register</a>
    </nav>

</body>
</html>

