<?php
require '../vendor/autoload.php';

$server   = 'public.mqtthq.com';
$port     = 1883;

use PhpMqtt\Client\MqttClient;

$mqtt = new MqttClient($server, $port);

$mqtt->connect();

$direction = $_POST['direction'];

switch ($direction) {
    case 'forward':
        $mqtt->publish('RCControl', 'Forwards', 0);
        break;
    case 'backward':
        $mqtt->publish('RCControl', 'Backwards', 0);
        break;
    case 'left':
        $mqtt->publish('RCControl', 'Left', 0);
        break;
    case 'right':
        $mqtt->publish('RCControl', 'Right', 0);
        break;
    default:
        // Handle unsupported direction
        break;
}
