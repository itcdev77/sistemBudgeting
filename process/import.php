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

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Csv"); // Ganti dengan format yang sesuai
        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray(null, true, true, true);

        // Loop melalui baris data Excel dan simpan ke database
        foreach ($rows as $row) {
            $data1 = $con->real_escape_string($row['A']);
            $data2 = $con->real_escape_string($row['B']);
            $data3 = 2;
            $data4 = 1;

            $sql = "INSERT INTO barang (nama_barang, keterangan, merek_id, kategori_id) VALUES ('$data1', '$data2', '$data3', '$data4')";

            if ($con->query($sql) === TRUE) {
                echo "Data berhasil disimpan ke database.<br>";
            } else {
                echo "Gagal menyimpan data: " . $con->error . "<br>";
            }
        }

        // Tampilkan data dalam tabel HTML
        echo '<table border="1">';
        foreach ($rows as $row) {
            echo '<tr>';
            echo '<td>' . $row['A'] . '</td>';
            echo '<td>' . $row['B'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    // $con->close();
}
