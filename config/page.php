<?php
if (isset($_GET['backup_app'])) {
    include('proses/backup_app.php');
} else if (isset($_GET['backup_db'])) {
    include('proses/backup_db.php');
} else if (isset($_GET['merek'])) {
    $master = $merek = true;
    $views = 'views/master/merek.php';
} else if (isset($_GET['kategori'])) {
    $master = $kategori = true;
    $views = 'views/master/kategori.php';
} else if (isset($_GET['barang'])) {
    $master = $barang = true;
    $views = 'views/master/barang.php';
} else if (isset($_GET['pengguna'])) {
    $master = $pengguna = true;
    $views = 'views/master/pengguna.php';
} else if (isset($_GET['barang_masuk'])) {
    $transaksi = $barang_masuk = true;
    $views = 'views/transaksi/barang_masuk.php';
} else if (isset($_GET['barang_keluar'])) {
    $transaksi = $barang_keluar = true;
    $views = 'views/transaksi/barang_keluar.php';
} else if (isset($_GET['lap_barang_masuk'])) {
    $laporan = $lap_barang_masuk = true;
    $views = 'views/laporan/lap_barang_masuk.php';
} else if (isset($_GET['lap_barang_keluar'])) {
    $laporan = $lap_barang_keluar = true;
    $views = 'views/laporan/lap_barang_keluar.php';
}

// Edit
else if (isset($_GET['prodev'])) {
    $master = $prodev = true;
    $views = 'views/master/prodev.php';
} else if (isset($_GET['cpp'])) {
    $master = $cpp = true;
    $views = 'views/master/cpp.php';
} else if (isset($_GET['ea'])) {
    $master = $ea = true;
    $views = 'views/master/ea.php';
} else if (isset($_GET['hse'])) {
    $master = $hse = true;
    $views = 'views/master/hse.php';
} else if (isset($_GET['itc'])) {
    $master = $itc = true;
    $views = 'views/master/itc.php';
} else if (isset($_GET['mep'])) {
    $master = $mep = true;
    $views = 'views/master/mep.php';
} else if (isset($_GET['scm'])) {
    $master = $scm = true;
    $views = 'views/master/scm.php';
} else if (isset($_GET['ship'])) {
    $master = $ship = true;
    $views = 'views/master/ship.php';
} else if (isset($_GET['survey'])) {
    $master = $survey = true;
    $views = 'views/master/survey.php';
} else if (isset($_GET['get_budget'])) {
    $master = $get_budget = true;
    $views = 'views/master/get_budget.php';
} else if (isset($_GET['get_budget2'])) {
    $master = $get_budget = true;
    $views = 'views/master/get_budget2.php';
}

//page untuk split budget..
else if (isset($_GET['split'])) {
    $master = $split = true;
    $views = 'views/master/split.php';
}
//Transaksi
else if (isset($_GET['trnsk_prodev'])) {
    $transaksi = $trnsk_prodev = true;
    $views = 'views/transaksi/trnsk_prodev.php';
} else if (isset($_GET['trnsk_stok'])) {
    $transaksi = $trnsk_stok = true;
    $views = 'views/transaksi/trnsk_stok.php';
} else if (isset($_GET['trnsk_split'])) {
    $transaksi = $trnsk_split = true;
    $views = 'views/transaksi/trnsk_split.php';
}
// 

// Log Transaksi...
else if (isset($_GET['trnsk_berhasil'])) {
    $log_transaksi = $trnsk_berhasil = true;
    $views = 'views/log_transaksi/trnsk_berhasil.php';
} else if (isset($_GET['trnsk_gagal'])) {
    $log_transaksi = $trnsk_gagal = true;
    $views = 'views/log_transaksi/trnsk_gagal.php';
}
// 

else {
    $home = true;
    $views = 'views/home.php';
}
