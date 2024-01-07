<?php
session_start();
include('../config/conn.php');
include('../config/function.php');

// untuk tambah barang..
if (isset($_POST['tambah'])) {
    $merek_id = $_POST['merek_id'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi = $_POST['deskripsi'];
    $keterangan = $_POST['ket'];
    $kode_budget = $_POST['kode_budget'];
    $departemen = $_POST['departemen'];
    $waktu_input = date("Y-m-d H:i:s");
    $peruntukan = $_POST['peruntukan'];


    $insert = mysqli_query($con, "INSERT INTO prodev (merek_id, kategori_id, deskripsi, keterangan, kode_budget, departemen, waktu_input, peruntukan, price, price_update, price_perUnit) VALUES ('$merek_id','$kategori_id','$deskripsi','$keterangan','$kode_budget', '$departemen', '$waktu_input', '$peruntukan', NULL, NULL, NULL)") or die(mysqli_error($con));
    if ($insert) {
        $success = 'Berhasil menambahkan data barang';
    } else {
        $error = 'Gagal menambahkan data barang';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?prodev');
}

//untuk lempar transaksi split ke table trnsk_prodev....
if (isset($_POST['tambah_split'])) {
    $deskripsi1 = $_POST['deskripsi1']; // ke table deskripsi
    $deskripsi2 = $_POST['deskripsi2']; // ke table deskripsi 2
    $kode_budget = $_POST['kode_budget']; // ke table kode_budget
    $price_bgt = $_POST['price_bgt']; // ke table price
    $price_perUnit = $_POST['price_perUnit']; // ke table price_perUnit
    $qty_test1 = $_POST['qty_test1']; //ke table stok dan stok_upd
    $kode_budget2 = $_POST['kode_budget2']; //ke table kode_budget2
    $bgt_price = $_POST['bgt_price']; //ke table price2
    $price_perUnit2 = $_POST['price_perUnit2']; //ke table price_perUnit2
    $qty_test = $_POST['qty_test']; //ke table stok2 dan stok_upd2
    $ambilBudget = $_POST['ambilBudget']; //ke table split_price

    //untuk detail transaksi
    $price_budget = $_POST['price_budget']; //masuk ke table trans_price1
    $split2 = $_POST['split2']; //masuk ke table trans_price2
    //

    $ket = $_POST['ket']; //ke table ket
    $jenis_trnsk = 'split'; // ke table jenis_trnsk

    $waktu_trnsk = date("Y-m-d H:i:s");

    $insert = mysqli_query($con, "INSERT INTO trnsk_prodev (deskripsi, deskripsi2, kode_budget, price, price_perUnit, stok, stok_upd, kode_budget2, price2, price_perUnit2, stok2, stok_upd2, split_price, trans_price1, trans_price2, ket, jenis_trnsk, waktu_trnsk) VALUES ('$deskripsi1','$deskripsi2','$kode_budget','$price_bgt','$price_perUnit','$qty_test1','$qty_test1','$kode_budget2','$bgt_price','$price_perUnit2','$qty_test','$qty_test','$ambilBudget','$price_budget','$split2','$ket','$jenis_trnsk','$waktu_trnsk')") or die(mysqli_error($con));

    if ($insert) {
        $success = 'Berhasil';
    } else {
        $error = 'Gagal';
    }
    $_SESSION['success'] = $success;
    $_SESSION['error'] = $error;
    header('Location:../?trnsk_split');
}

//untuk update barang (insert akan di hapus)
if (isset($_POST['ubah'])) {
    $id = $_POST['idbarang'];
    $merek_id = $_POST['merek_id'];
    $kategori_id = $_POST['kategori_id'];
    $deskripsi = $_POST['deskripsi'];
    $price = $_POST['price'];
    $stok = $_POST['stok'];
    $price_perUnit = $_POST['price_perUnit'];
    $price_perUnit_upd = $_POST['price_perUnit_upd'];



    //untuk update di table departement terkait
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

// action untuk delete data
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
