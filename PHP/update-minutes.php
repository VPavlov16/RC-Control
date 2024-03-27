<?php
// Include the necessary files and initialize the session
require "nav.php";


// Function to update user minutes in the database
function updateUserMinutes($pdo, $userId, $remainingMinutes) {
    $sql = "UPDATE users SET minutes = :minutes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':minutes', $remainingMinutes);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
}

// Check if the user is logged in
if (isset($_SESSION['user'])) {
    // Get user details from the session
    $user = $_SESSION['user'];
    $userId = $user['id'];

    // Get the remaining minutes from the POST request
    if (isset($_POST['minutes'])) {
        $remainingMinutes = $_POST['minutes'];

        // Update user minutes in the database
        updateUserMinutes($pdo, $userId, $remainingMinutes);
        echo "Minutes updated successfully in the database.";
    } else {
        // If minutes parameter is not set, return error
        echo "Minutes parameter is missing.";
    }
} else {
    // If user is not logged in, return error
    echo "User not logged in.";
}
?>
