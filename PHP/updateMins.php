<?php
session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../Pages/register.php");
    exit();
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['minutes']>0) {
    // Retrieve user ID and remaining minutes from the POST data
    $user_id = $_POST['user_id'];
    $minutes = $_POST['minutes'];
    

    // Update the user's remaining minutes in the database
    $sql = "UPDATE users SET minutes = :minutes WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':minutes', $minutes);
    $stmt->bindParam(':user_id', $user_id);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // The update was successful
        echo "Remaining minutes updated successfully.";
    } else {
        // An error occurred while updating the minutes
        echo "Error updating remaining minutes.";
    }
} else {
    // If the request method is not POST, respond with an error
    http_response_code(405);
    echo "Method Not Allowed";
    header("Location: ../Pages/prices.php");

}
?>