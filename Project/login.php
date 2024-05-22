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
    $phone = $_POST["phone"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, redirect to homepage
        header("Location: homepage.html");
        exit; // Ensure no further code execution after redirect
    } else {
        // No user found with this phone number, redirect back to sign-in page with error message
        header("Location: index.html?error=" . urlencode("No account with this phone number."));
        exit; // Ensure no further code execution after redirect
    }

    $stmt->close();
}

$conn->close();
?>