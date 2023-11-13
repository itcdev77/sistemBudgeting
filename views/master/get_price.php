<?php
include('conn.php');

if (isset($_GET['id'])) {
    $itemId = $_GET['id'];
    $query = mysqli_query($con, "SELECT price FROM prodev WHERE idbarang = '$itemId'");
    $row = mysqli_fetch_assoc($query);
    echo "<option value='" . $row['price'] . "'>" . $row['price'] . "</option>";
} else {
    echo "<option value=''>-- Pilih Kategori --</option>";
}
