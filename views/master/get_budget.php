<?php
// Menghubungkan ke database
include('./config/conn.php');

// Ambil split dari permintaan AJAX
$split = $_POST['username']; // Sesuaikan dengan nama yang dikirimkan melalui AJAX

// Query untuk mengambil split-budget berdasarkan split
$query = "SELECT price FROM prodev WHERE deskripsi = '" . mysqli_real_escape_string($con, $split) . "'";
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $price = $row['price'];
    echo $price;
} else {
    echo "--"; // Jika tidak ada data yang ditemukan
}
