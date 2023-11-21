<?php
session_start();
include('../config/conn.php');
include('../config/function.php');

// if (isset($_POST['tambah'])) {
//     $nama_barang = $_POST['nama_barang'];
//     $merek_id = $_POST['merek_id'];
//     $kategori_id = $_POST['kategori_id'];
//     $keterangan = $_POST['keterangan'];
//     $stok = 0;

//     $insert = mysqli_query($con, "INSERT INTO barang (merek_id, kategori_id, nama_barang, keterangan, stok) VALUES ('$merek_id','$kategori_id','$nama_barang','$keterangan','$stok')") or die(mysqli_error($con));
//     if ($insert) {
//         $success = 'Berhasil menambahkan data barang';
//     } else {
//         $error = 'Gagal menambahkan data barang';
//     }
//     $_SESSION['success'] = $success;
//     $_SESSION['error'] = $error;
//     header('Location:../?barang');
// }

if (isset($_POST['ubah'])) {
    $id = $_POST['idbarang'];
    $merek_id = $_POST['merek_id'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi = $_POST['deskripsi'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $price_perUnit = $_POST['price_perUnit'];
    $price_perUnit_upd = $_POST['price_perUnit_upd'];



    //unutk update di table departement terkait
    $update = mysqli_query($con, "UPDATE prodev SET merek_id='$merek_id', kategori_id='$kategori_id', deskripsi='$deskripsi', price='$price', stok='$stok', price_perUnit='$price_perUnit', price_perUnit_upd='$price_perUnit_upd' WHERE idbarang='$id'") or die("Error: " . mysqli_error($con));

    $kode_budget = $_POST['kode_budget'];
    $ket = $_POST['ket'];
    $waktu_trnsk = date("Y-m-d H:i:s");
    $departemen = $_POST['departemen'];
    $stok_upd = $_POST['stok_update'];
    $di_ambil = $_POST['ambil_stok'];

    //jenis transaksi
    $jenis_trnsk = $_POST['trnsk'];


    //untuk insert di table log departemen terkait
    $log_update = mysqli_query($con, "INSERT INTO trnsk_prodev (kode_budget, merek_id, kategori_id, deskripsi, price, price_perUnit, stok, ket, waktu_trnsk, departemen, stok_upd, di_ambil, jenis_trnsk) VALUES ('$kode_budget', '$merek_id', '$kategori_id', '$deskripsi', '$price', '$price_perUnit', '$stok', '$ket', '$waktu_trnsk', '$departemen', '$stok_upd', '$di_ambil', '$jenis_trnsk')") or die("Error: " . mysqli_error($con));

    if ($update || $log_update) {
        $success = 'Berhasil mengubah data barang';
    } else {
        $error = 'Gagal mengubah data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?trnsk_prodev');
}

if (decrypt($_GET['act']) == 'delete' && isset($_GET['id']) != "") {
    // echo $_GET['act'];die;
    $id = decrypt($_GET['id']);
    $delete = mysqli_query($con, "DELETE FROM prodev WHERE idbarang='$id'") or die(mysqli_error($con));
    if ($delete) {
        $success = "Data barang berhasil dihapus";
    } else {
        $error = "Data barang gagal dihapus";
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?prodev');
}
