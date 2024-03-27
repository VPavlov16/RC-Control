<?php

// Check if the direction parameter is set
if (isset($_POST['direction'])) {
    // Retrieve the direction from the POST parameters
    $direction = $_POST['direction'];

    // Construct the URL with the ESP32's IP address
    $esp_ip = "192.168.145.54"; // Update this with your ESP32's IP address
    $url = "http://$esp_ip/$direction"; // Use the direction as the endpoint

    // Send HTTP request to the ESP32
    $options = array(
        'http' => array(
            'method'  => 'GET', // Use GET method since ESP32 handles HTTP_GET requests
            'header'  => 'Content-Type: application/x-www-form-urlencoded'
        )
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result !== false) {
        // HTTP request successful
        echo "HTTP request sent successfully.";
    } else {
        // Failed to send HTTP request
        echo "Error sending HTTP request.";
    }
} else {
    // If direction parameter is not set, return error
    echo "Direction parameter is missing.";
}
?>
