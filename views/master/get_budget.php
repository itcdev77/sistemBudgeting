<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "inventaris";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$merekId = $_POST['merek_id'];

$sql = "SELECT price FROM prodev WHERE deskripsi = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $merekId); // "s" indicates a string parameter
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $harga = $row['price'];
            echo $harga;
        } else {
            echo "error";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error in preparing statement: " . $conn->error;
}

$conn->close();
