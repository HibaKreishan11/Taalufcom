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
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $blood_donation = $_POST["blood-donation"];
    $blood_type = isset($_POST["blood-type"]) ? $_POST["blood-type"] : NULL;
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : NULL;
    $weight = isset($_POST["weight"]) ? $_POST["weight"] : NULL;
    $hbp = isset($_POST["hbp"]) ? $_POST["hbp"] : NULL;
    $diabetes = isset($_POST["diabetes"]) ? $_POST["diabetes"] : NULL;

    $stmt = $conn->prepare("INSERT INTO users (name, phone, age, address, blood_donation, blood_type, gender, weight, hbp, diabetes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssiss", $name, $phone, $age, $address, $blood_donation, $blood_type, $gender, $weight, $hbp, $diabetes);

    if ($stmt->execute()) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>