<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$btn = "";
$name = "";
$text = "";
if (isset($_SESSION['user'])) {
    debug_to_console($_SESSION['user']);
    $btn = "accatr";
    $name = "acc.php";
    $text = "Профил";
}else{
    $btn = "regatr";
    $name = "register.php";
    $text = "Регистриране";
}

$current_url = $_SERVER['REQUEST_URI'];
$filename = basename($current_url);
$homeatr = "";
$vehatr = "";
$conatr = "";

if($filename == "index.php"){
    $homeatr = "active";
}elseif($filename == "vehicles.php"){
    $vehatr = "active";
}elseif($filename == "control.php"){
    $conatr = "active";
}elseif($filename == $name){
    $btn = "active";
}


function debug_to_console($data){
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
?>


<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RC Control</title>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
</head>
<body>
    <nav class="nav nav-pills nav-justified">
        <a class="nav-link <?php echo $homeatr ?> navitem " href="index.php">Начало</a>
        <a class="nav-link <?php echo $vehatr ?> navitem " href="vehicles.php">RC Устройства</a>
        <a class="nav-link <?php echo $conatr ?> navitem " href="control.php">Управление</a>
        <a class="nav-link <?php echo $btn ?> navitem " href="<?php echo $name ?>"><?php echo $text ?></a>
    </nav>
</body>
</html>

