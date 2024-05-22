<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "donation_platform";

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
    $blood_type = isset($_POST["blood_type"]) ? $_POST["blood_type"] : NULL;
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : NULL;
    $weight = isset($_POST["weight"]) ? $_POST["weight"] : NULL;
    $hbp = isset($_POST["hbp"]) ? $_POST["hbp"] : NULL;
    $diabetes = isset($_POST["diabetes"]) ? $_POST["diabetes"] : NULL;

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, phone, age, address, blood_donation, blood_type, gender, weight, hbp, diabetes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    $stmt->bind_param("ssissssiss", $name, $phone, $age, $address, $blood_donation, $blood_type, $gender, $weight, $hbp, $diabetes);
    
    // Execute SQL statement
    if ($stmt->execute()) {
        // Redirect to homepage after successful data insertion
        header("Location: Homepage.html");
        exit; // Ensure that no further code is executed after the redirect
    } else {
        echo "Error executing statement: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
}

$conn->close();
?>