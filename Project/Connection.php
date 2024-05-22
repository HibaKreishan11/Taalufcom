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

    // Check if phone number is valid
    if (!preg_match('/^07[0-9]{8}$/', $phone)) {
        echo "Please enter a VALID Phone Number!";
        exit;
    }

    // Check if name contains only letters
    if (!preg_match('/^[a-zA-Z]+$/', $name)) {
        echo "Please enter a name that contains ONLY letters!";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO users (name, phone, age, address, blood_donation, blood_type, gender, weight, hbp, diabetes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissssiis", $name, $phone, $age, $address, $blood_donation, $blood_type, $gender, $weight, $hbp, $diabetes);

    try {
        if ($stmt->execute()) {
            header("Location: index.html");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            echo "<p style='color: red; font-weight: bold; font-size: larger;'>Phone Number already exists!</p>";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }

    $stmt->close();
}

$conn->close();
?>