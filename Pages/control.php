<?php
require "nav.php";
require '../vendor/autoload.php';


if (isset($_SESSION['user'])) {
    $mins = $user['minutes'];
}

$server   = 'public.mqtthq.com';
$port     = 1883;

use PhpMqtt\Client\MqttClient;

$mqtt = new MqttClient($server, $port);

$mqtt->connect();
//$mqtt->publish('RCControl', 'Hello!', 0);

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

    $svg = "";
    if ($selectedVehicle['name'] == "RC Speed Tank"){
        $svg = "tank.svg";
    } elseif ($selectedVehicle['name'] == "F1"){
        $svg = "f1.svg";
    } elseif ($selectedVehicle['name'] == "RC Benchy"){
        $svg = "benchy.svg";
    }
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

        button {
            font-size: 18px;
            padding: 10px 20px;
            background-color: #0a53be; 
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            margin: 5px 10px;
            cursor: pointer;
            border-radius: 8px;
        }

        button:hover {
            background-color: #0197F6; 
        }
        #keyboardButtons {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 3px solid blue;
            border-radius: 10px;
            background-color: #fff;
            padding: 20px;
            width: 300px;
        }

        .keyboard-row {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .keyboard-key {
            width: 50px;
            height: 50px;
            font-size: 16px;
            background-color: #0a53be; 
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .keyboard-key:hover {
            background-color: #0197F6;
        }

        #backButton {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 5px 10px;
            font-size: 14px; 
        }
    </style>
</head>
<body>

<?php if ($selectedVehicle !== null): ?>
    <div class="selected-vehicle">
        <a href="#">
            <img src="../images/svg/<?php echo $svg; ?>" alt="<?php echo $selectedVehicle['name']; ?>">
        </a>
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
        <button id="startButton" style="position: fixed; top: 200px; left: 50%; transform: translateX(-50%);">Старт</button>
        <div id="controlButtons" style="display: none; text-align: center; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <button id="wasdButton">WASD</button>
            <button id="arrowsButton">Arrows</button>
        </div>
        <div id="keyboardButtons">
            <button id="backButton">Назад</button>
            <div class="keyboard-row wasd">
                <button class="keyboard-key" onclick="sendMqttMessage('forward');" >W</button>
            </div>
            <div class="keyboard-row wasd">
                <button class="keyboard-key" onclick="sendMqttMessage('left');">A</button>
                <button class="keyboard-key" onclick="sendMqttMessage('backwards');">S</button>
                <button class="keyboard-key" onclick="sendMqttMessage('right');">D</button>
            </div>
            <div class="keyboard-row arrows">
                <button class="keyboard-key" onclick="sendMqttMessage('forward');">↑</button>
            </div>
            <div class="keyboard-row arrows">
                <button class="keyboard-key" onclick="sendMqttMessage('left');">←</button>
                <button class="keyboard-key" onclick="sendMqttMessage('backwards');">↓</button>
                <button class="keyboard-key" onclick="sendMqttMessage('right');">→</button>
            </div>
        </div>
    <?php endif; ?>

<?php else: ?>
    <div class="no-vehicle">
        <p>Моля, изберете устройство!</p>
        <a class="btn btn-primary" href="vehicles.php">Избери устройство</a>
    </div>
<?php endif; ?>

<script>
    function sendMqttMessage(direction) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('MQTT message sent successfully.');
                } else {
                    console.error('Error sending MQTT message.');
                }
            }
        };
        xhr.open("POST", "../PHP/send_message.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("direction=" + direction);
    }

    document.getElementById('startButton').addEventListener('click', function () {
        document.getElementById('startButton').style.display = 'none';
        document.getElementById('controlButtons').style.display = 'flex';
    });

    document.getElementById('wasdButton').addEventListener('click', function () {
        document.getElementById('keyboardButtons').style.display = 'block';
        document.querySelectorAll('.wasd').forEach(function(el) {
            el.style.display = 'flex';
        });
        document.querySelectorAll('.arrows').forEach(function(el) {
            el.style.display = 'none';
        });
    });

    document.getElementById('arrowsButton').addEventListener('click', function () {
        document.getElementById('keyboardButtons').style.display = 'block';
        document.querySelectorAll('.wasd').forEach(function(el) {
            el.style.display = 'none';
        });
        document.querySelectorAll('.arrows').forEach(function(el) {
            el.style.display = 'flex';
        });
    });

    document.getElementById('backButton').addEventListener('click', function () {
        document.getElementById('keyboardButtons').style.display = 'none';
        document.getElementById('controlButtons').style.display = 'block';
    });

    document.addEventListener('keydown', function(event) {
        switch(event.key) {
            case 'w':
            case 'ArrowUp':
                sendMqttMessage('forward');
                break;
            case 'a':
            case 'ArrowLeft':
                sendMqttMessage('left');
                break;
            case 's':
            case 'ArrowDown':
                sendMqttMessage('backward');
                break;
            case 'd':
            case 'ArrowRight':
                sendMqttMessage('right');
                break;
            default:
                break;
        }
    });
</script>

</body>
</html>