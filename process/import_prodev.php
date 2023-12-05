<?php
// Sambungkan ke database Anda (gantilah dengan pengaturan koneksi Anda)
include('../config/conn.php');
include('../config/function.php');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan file Excel telah diunggah
    if (isset($_FILES["excel_file"])) {
        $file = $_FILES["excel_file"]["tmp_name"];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Csv"); // Bilang ke user emang harus CSV (biar gampang aja hehe)
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        // Loop melalui baris data Excel dan simpan ke database
        foreach ($rows as $row) {
            $data1 = 'PRODEV';
            $data2 = $con->real_escape_string($row['D']); //deskripsi
            $data3 = $con->real_escape_string($row['E']); //peruntukan
            $data4 = 8;
            $data5 = 4;
            $data6 = date("Y-m-d H:i:s");
            $data7 = $con->real_escape_string($row['B']); //perusahaan
            $data8 = $con->real_escape_string($row['C']); //kategori
            $data9 = $con->real_escape_string($row['F']); //satuan/unit
            $data10 = $con->real_escape_string($row['A']); //kode budget

            //unutuk import data dengan format float
            $data11 = floatval(str_replace(['.', ','], '', $con->real_escape_string($row['G'])));
            $data12 = floatval(str_replace(['.', ','], '', $con->real_escape_string($row['H'])));
            $data13 = floatval(str_replace(['.', ','], '', $con->real_escape_string($row['I'])));


            $sql = "INSERT INTO prodev (departemen, deskripsi, peruntukan, merek_id, kategori_id, waktu_input, perusahaan, kategori, satuanUnit, kode_budget, price_perUnit, stok, stok_update, price, price_update) VALUES ('$data1', '$data2', '$data3', '$data4', '$data5', '$data6', '$data7', '$data8', '$data9', '$data10', '$data11', '$data12', '$data12', '$data13', '$data13')";

            if ($con->query($sql) === TRUE) {
                echo "Data berhasil disimpan ke database.<br>";
            } else {
                echo "Gagal menyimpan data: " . $con->error . "<br>";
            }
        }

        // Tampilkan data dalam tabel HTML
        // echo '<table border="1">';
        // foreach ($rows as $row) {
        //     echo '<tr>';
        //     echo '<td>' . $row['A'] . '</td>';
        //     echo '<td>' . $row['B'] . '</td>';
        //     echo '</tr>';
        // }
        // echo '</table>';

        echo 'DATA BERHASIL DI IMPORT!!';
    }

    // $con->close();
}
