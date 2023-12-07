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

$sql = "SELECT price, stok, kode_budget, price_perUnit FROM prodev WHERE deskripsi = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $merekId);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result !== false) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $harga = $row['price'];
            $stok = $row['stok'];
            $kode_budget = $row['kode_budget'];
            $price_perUnit = $row['price_perUnit'];
            $Dharga = $row['price'];

            // Memformat harga dengan titik sebagai pemisah ribuan
            $harga_formatted = number_format($Dharga, 0, ',', '.');
            $price = number_format($price_perUnit, 0, ',', '.');

            // Mengirim respons sebagai JSON dengan harga dan stok
            echo json_encode(array('harga' => $harga, 'stok' => $stok, 'kode_budget' => $kode_budget, 'price_perUnit' => $price, 'Dharga' => $harga_formatted));
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
