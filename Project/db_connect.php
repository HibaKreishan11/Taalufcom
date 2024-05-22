<?php
$servername = "127.0.0.1"; // Use localhost IP address
$username = "root"; // Use the username from your phpMyAdmin configuration
$password = ""; // Use the password from your phpMyAdmin configuration
$dbname = "donation_platform"; // Change this to the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $blood_donation = $_POST["blood-donation"];

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, phone, age, address, blood_donation) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $phone, $age, $address, $blood_donation);

    // Execute SQL statement
    if ($stmt->execute()) {
        // Redirect to a success page
        header("Location: signup_success.html");
        exit; // Ensure that no further code is executed after the redirect
    } else {
        // Redirect to an error page
        header("Location: signup_error.html");
        exit; // Ensure that no further code is executed after the redirect
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>