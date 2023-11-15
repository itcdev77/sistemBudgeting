<?php hakAkses(['admin', 'user']);

include('./config/conn.php');

?>



<script>
    function submit(x) {
        if (x == 'add') {
            $('[name="deskripsi"]').val("");
            $('[name="merek_id"]').val("").trigger('change');
            $('[name="kategori_id"]').val("").trigger('change');
            $('[name="price"]').val("");
            $('[name="stok"]').val("");
            $('[name="price_perUnit"]').val("");
            //split budget
            $('[name="split"]').val("");
            $('[name="split-budget"]').val("");

            $('#barangModal .modal-title').html('Tambah Barang');
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#barangModal .modal-title').html('Edit Barang');
            $('[name="tambah"]').hide();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_barang.php',
                dataType: 'json',
                success: function(data) {

                    var formattedPrice = 'Rp. ' + data.price;

                    $('[name="idbarang"]').val(data.idbarang);
                    $('[name="merek_id"]').val(data.merek_id).trigger('change');
                    $('[name="kategori_id"]').val(data.kategori_id).trigger('change');
                    $('[name="departemen"]').val(data.departemen);
                    $('[name="deskripsi"]').val(data.deskripsi);
                    $('[name="price"]').val(data.price);
                    $('[name="price_perUnit"]').val(data.price_perUnit);
                    $('[name="stok"]').val(data.stok);
                    $('[name="stok_update"]').val(data.stok);
                    $('[name="price_update"]').val(data.stok);

                    //split budget
                    // $('[name="split"]').val(data.split);
                    // $('[name="split-budget"]').val(data.split_budget);
                }
            });
        }
    }
</script>



<script>
    function importData() {
        // Membuat objek FormData untuk mengirim file
        var formData = new FormData();
        formData.append('excel_file', $('#excelFile')[0].files[0]);

        // Melakukan request AJAX
        $.ajax({
            url: '<?= base_url(); ?>process/import_prodev.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Menangani respons dari server, misalnya menampilkan pesan sukses
                alert(response);
            },
            error: function(xhr, status, error) {
                // Menangani kesalahan jika ada
                console.error(xhr.responseText);
            }
        });
    }
</script>


<script>
    // Menambahkan event listener ke dropdown
    document.getElementById("username").addEventListener("change", function() {
        // Mendapatkan nilai username yang dipilih
        var selectedUsername = this.value;

        // Menggunakan AJAX untuk mengambil data split-budget berdasarkan username
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_budget.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Mendapatkan data split-budget dari response
                var responseArray = xhr.responseText.split(',');

                // Memasukkan data split-budget ke dalam input split-budget
                document.getElementById("split-budget").value = responseArray[0];
            }
        };
        xhr.send("username=" + selectedUsername);
    });
</script>






<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Temukan elemen input stok
        var stokInput = document.querySelector('input[name="stok"]');

        // Tambahkan event listener untuk perubahan nilai pada input stok
        stokInput.addEventListener("input", function() {
            // Temukan elemen input harga
            var hargaInput = document.querySelector('input[name="price"]');

            // Dapatkan nilai stok baru
            var stokValue = parseFloat(stokInput.value);

            // Lakukan operasi atau perhitungan apapun untuk mengganti nilai harga sesuai kebutuhan Anda
            // Misalnya, Anda ingin mengganti harga menjadi dua kali lipat dari nilai stok
            var newPrice = stokValue * 1;

            // Update nilai input harga
            hargaInput.value = newPrice;
        });
    });
</script> -->

<!-- js jadi -->
<!-- <script>
    function updateBudget() {
        var price = parseFloat(document.getElementById('price').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var budget = price - price_perUnit;
        document.getElementById('budget').value = budget;
    }

    function confirmUpdateStok() {
        console.log('confirmUpdateStok dipanggil');
        if (confirm('Anda akan mengurangi stok. Lanjutkan?')) {
            console.log('User menekan OK');
            updateStok();
        } else {
            console.log('User menekan Cancel');
            var stok = parseFloat(document.getElementById('stok').value) || 0;
            var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
            var currentPrice = stok * price_perUnit;
            document.getElementById('stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }

    function updateStok() {
        var stok = parseFloat(document.getElementById('stok').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var newPrice = stok * price_perUnit;
        var currentPrice = parseFloat(document.getElementById('price').value) || 0;

        if (newPrice < currentPrice) {
            document.getElementById('price').value = newPrice;
            updateBudget();
        } else {
            document.getElementById('stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }

    function updatePriceFromSplitBudget() {
        var splitBudget = parseFloat(document.getElementById('split-budget').value) || 0;
        var currentPrice = parseFloat(document.getElementById('price').value) || 0;
        var newPrice = currentPrice - splitBudget;

        // Setel nilai price
        document.getElementById('price').value = newPrice;

        // Update budget setelah mengubah price
        updateBudget();
    }
</script> -->


<!-- <script>
    var originalStokValue; // Menyimpan nilai stok sebelum perubahan

    function updateBudget() {
        var price = parseFloat(document.getElementById('price').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var stok = parseFloat(document.getElementById('stok').value) || 0;

        // Validasi agar price_perUnit tidak melebihi batas stok
        var maxPricePerUnit = price / stok;
        if (price_perUnit > maxPricePerUnit) {
            alert('Harga per unit tidak boleh melebihi batas stok. Harga per unit akan disetel ke nilai maksimum yang diperbolehkan.');
            document.getElementById('price_perUnit').value = maxPricePerUnit;
            price_perUnit = maxPricePerUnit;
        }

        var budget = price - price_perUnit;
        document.getElementById('budget').value = budget;
    }

    function confirmUpdateStok() {
        console.log('confirmUpdateStok called');
        var stokElement = document.getElementById('stok');
        originalStokValue = parseFloat(stokElement.value) || 0; // Simpan nilai stok sebelum perubahan

        if (confirm('Anda akan mengurangi stok. Lanjutkan?')) {
            console.log('User pressed OK');
            updateStok();
        } else {
            console.log('User pressed Cancel');
            stokElement.value = originalStokValue; // Kembalikan nilai stok jika pengguna menekan Cancel
        }
    }

    function updateStok() {
        var stok = parseFloat(document.getElementById('stok').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var newPrice = stok * price_perUnit;
        var currentPrice = parseFloat(document.getElementById('price').value) || 0;

        if (newPrice < currentPrice) {
            document.getElementById('price').value = newPrice;
            updateBudget();
        } else {
            document.getElementById('stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }
</script> -->


<script>
    function updateBudget() {
        var price = parseFloat(document.getElementById('price').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var budget = price - price_perUnit;
        document.getElementById('budget').value = budget;
    }

    function confirmUpdateStok() {
        console.log('confirmUpdateStok called');
        if (confirm('Anda akan mengurangi stok. Lanjutkan?')) {
            console.log('User pressed OK');
            updateStok();
        } else {
            console.log('User pressed Cancel');
            var stok = parseFloat(document.getElementById('stok').value) || 0;
            var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
            var currentPrice = stok * price_perUnit;
            document.getElementById('stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }

    function updateStok() {
        var stok = parseFloat(document.getElementById('stok').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('price_perUnit').value) || 0;
        var newPrice = stok * price_perUnit;
        var currentPrice = parseFloat(document.getElementById('price').value) || 0;

        if (newPrice < currentPrice) {
            document.getElementById('price').value = newPrice;
            updateBudget();
        } else {
            document.getElementById('stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }

    function confirmAndUpdateSplitBudget() {
        var splitBudget = parseFloat(document.getElementById('split-budget').value) || 0;
        var currentPrice = parseFloat(document.getElementById('price').value) || 0;

        // Konfirmasi sebelum menjumlahkan split-budget dengan price
        if (confirm('Anda akan melakukan split budget!!. Lanjutkan?')) {
            // Jika pengguna menekan OK, update nilai price dan budget
            document.getElementById('price').value = currentPrice - splitBudget;

            updateBudget();

        }
    }
</script>



<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Import Budget PRODEV</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#barangModal" onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a> -->

            <!-- <form action="<?= base_url(); ?>process/import.php" method="post" enctype="multipart/form-data">
                <input class="btn btn-primary btn-icon-split btn-sm" type="file" name="excel_file">
                <input class="btn btn-primary btn-icon-split btn-sm" type="submit" value="Import">
            </form> -->
            <?php if ($_SESSION['level'] == 'admin') { ?>
                <input type="file" id="excelFile" class="">
                <!-- <input type="text" id="" class="" value="<?= strtoupper($_SESSION['iduser']); ?>" hidden> -->
                <button onclick="importData()" class="btn btn-primary btn-icon-split btn-sm">Import</button>
            <?php }; ?>

            <!-- <p><?= $user_data['deskripsi'] ?></p> -->


        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10">KODE</th>
                            <th>WAKTU</th>
                            <th>PERUSAHAAN</th>
                            <th>KATEGORI</th>
                            <th>DESKRIPSI</th>
                            <th>PERUNTUKAN</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th width="100">UNIT PRICE</th>
                                <th>QTY BF</th>
                                <th>QTY</th>
                                <th width="100">BGT BF</th>
                                <th width="100">BGT</th>
                            <?php endif; ?>

                            <?php if ($_SESSION['level'] == 'user') : ?>
                                <th width="50">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // $query = mysqli_query($con, "SELECT * FROM barang  ORDER BY idbarang DESC") or die(mysqli_error($con));
                        $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>

                                <td><?= $row['waktu_input']; ?></td>

                                <td><?= $row['keterangan']; ?></td>

                                <td><?= $row['nama_kategori']; ?></td>

                                <td><?= $row['deskripsi']; ?></td>

                                <td><?= $row['peruntukan']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price_perUnit']; ?></td>
                                <?php endif; ?>

                                <td><?= $row['stok_update']; ?></td>

                                <td><?= $row['stok']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price_update']; ?></td>
                                <?php endif; ?>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price']; ?></td>
                                <?php endif; ?>

                                <?php if ($_SESSION['level'] == 'user') : ?>
                                    <td>
                                        <a href="#barangModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                        <!-- <a href="<?= base_url(); ?>/process/barang.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['idbarang']); ?>" class="btn btn-sm btn-circle btn-danger btn-hapus"><i class="fas fa-trash"></i></a> -->
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal Tambah barang -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/barang.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">


                                <input type="hidden" name="idbarang" class="form-control">

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="price">Budget:</label>
                                        <input type="number" class="form-control" name="price" id="price" onchange="updateBudget()" readonly>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="price_perUnit">Price Per Unit:</label>
                                        <input type="number" class="form-control" name="price_perUnit" id="price_perUnit" onchange="updateBudget()" readonly>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="stok">Qty:</label>
                                        <input type="number" class="form-control" name="stok" id="stok" oninput="confirmUpdateStok()">
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Perusahaan :</label>
                                <select name="merek_id" id="merek_id" class="form-select select2" style="width:100%;">
                                    <option value="">-- Deskripsi Barang --</option>
                                    <?= list_merek(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Kategori :</label>
                                <select name="kategori_id" id="kategori_id" class="form-select select2" style="width:100%;" hidden>
                                    <option value="">-- Kategori Barang --</option>
                                    <?= list_kategori(); ?>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Split budget dengan :</label>
                                <select name="split" id="username" class="form-select select2" style="width:100%;">
                                    <!-- <option value="">-- Deskripsi Barang --</option>
                                     -->
                                    <?php

                                    // Menghubungkan ke database
                                    // $con = mysqli_connect("localhost", "root", "", "inventaris");
                                    include('../config/conn.php');

                                    // Periksa koneksi
                                    if (!$con) {
                                        die("Koneksi ke database gagal: " . mysqli_connect_error());
                                    }
                                    // Query untuk mengambil nama pengguna dari tabel
                                    // $query = "SELECT name FROM user WHERE level <= 4";
                                    // $result = mysqli_query($koneksi, $query);
                                    $sau = "SELECT * FROM prodev ORDER BY deskripsi ASC";
                                    $query2 = mysqli_query($con, "$sau") or die('mysql_error');

                                    // Loop melalui hasil query dan membuat pilihan dropdown
                                    while ($user_data = mysqli_fetch_array($query2)) {
                                        echo "<option value=\"" . $user_data['idbarang'] . "\">" . $user_data['deskripsi'] . "</option>";
                                    }


                                    // Tutup koneksi ke database
                                    // mysqli_close($con);
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_id">Jumlah budget yang di ambil :</label>
                                <input type="number" class="form-control" name="split-budget" id="split-budget" oninput="updatePriceFromSplitBudget()">

                            </div>
                        </div>

                        <div class="col-md-6 mt-2 ">
                            <a style="margin-left: 180%;" class="btn btn-danger" onclick="confirmAndUpdateSplitBudget()"><i style="color: white;" class="fa fa-plus"></i>
                            </a>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>