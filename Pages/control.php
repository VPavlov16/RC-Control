<?php
require "nav.php";
$mins = $user['minutes'];

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "admin";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$selectedVehicleId = isset($_GET['vid']) ? $_GET['vid'] : null;

if ($selectedVehicleId) {
    $sql = "SELECT name, usedby, pic FROM vehicles WHERE vid = :vid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':vid', $selectedVehicleId);
    $stmt->execute();
    $selectedVehicle = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $selectedVehicle = null;
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Page</title>
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <style>
        .selected-vehicle {
            display: flex;
            align-items: center;
            position: fixed;
            top: 50px;
            left: 10px;
            margin: 10px;
            border: 3px solid blue;
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
        }

        .selected-vehicle img {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }

        .minutes {
            display: flex;
            align-items: center;
            position: fixed;
            top: 50px;
            right: 10px;
            margin: 10px;
            border: 3px solid blue;
            padding: 10px;
            border-radius: 10px;
            background-color: #fff;
        }

        .no-vehicle {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
    </style>
</head>
<body>

<?php if ($selectedVehicle !== null): ?>
    <div class="selected-vehicle">
        <img src="../images/<?php echo $selectedVehicle['pic']; ?>" alt="<?php echo $selectedVehicle['name']; ?>">
        <p style="margin: 0;"><?php echo $selectedVehicle['name']; ?></p>
    </div>

    <?php if ($selectedVehicle['usedby'] !== null): ?>
        <div class="no-vehicle">
            <p>Моля, изберете друго устройство!</p>
            <a class="btn btn-primary" href="vehicles.php">Избери устройство</a>
        </div>
    <?php else: ?>
        <div class="minutes">
            <p style="margin: 0;">Налични минути: <?php echo $mins; ?></p>
        </div>
        <button id="startButton" style="position: fixed; top: 200px; left: 50%; transform: translateX(-50%);">Start</button>
    <?php endif; ?>

<?php else: ?>
    <div class="no-vehicle">
        <p>Моля, изберете устройство!</p>
        <a class="btn btn-primary" href="vehicles.php">Избери устройство</a>
    </div>
<?php endif; ?>

<script>
    document.getElementById('startButton').addEventListener('click', function () {
        // Your start button logic here
    });
</script>

</body>
</html>