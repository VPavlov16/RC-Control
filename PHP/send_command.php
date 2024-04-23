<?php

if (isset($_POST['direction'])) {
    $direction = $_POST['direction'];
    $esp_ip = "192.168.48.73"; 
    $url = "http://$esp_ip/$direction"; 

    // send http
    $options = array(
        'http' => array(
            'method'  => 'GET', 
            'header'  => 'Content-Type: application/x-www-form-urlencoded'
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result !== false) {
        echo "HTTP request sent successfully.";
    } else {
        echo "Error sending HTTP request.";
    }
} else {
    echo "Direction parameter is missing.";
}
?>
