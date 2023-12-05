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
            //stok
            $('[name="stok"]').val("");
            $('[name="stok_update"]').val("");
            $('[name="ambil_stok"]').val("");
            //
            $('[name="price_perUnit"]').val("");
            //split budget
            $('[name="split"]').val("");
            $('[name="split-budget"]').val("");
            //
            $('[name="kode_budget"]').val("");
            $('[name="ket"]').val("");
            $('[name="dapartemen"]').val("");
            $('[name="price_perUnit_upd"]').val("");

            //insert jenis transaksi

            $('[name="trnsk"]').val("");


            // $('#barangModal .modal-title').html('Tambah Barang');
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#barangModal .modal-title').html('Edit Price Per Unit');
            $('#ambilStock .modal-title').html('Ambil Stok');
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

                    // var formattedPrice = 'Rp. ' + data.price;

                    $('[name="idbarang"]').val(data.idbarang);
                    $('[name="merek_id"]').val(data.merek_id).trigger('change');
                    $('[name="kategori_id"]').val(data.kategori_id).trigger('change');
                    $('[name="departemen"]').val(data.departemen);
                    $('[name="deskripsi"]').val(data.deskripsi);
                    $('[name="price"]').val(data.price);
                    $('[name="price_display"]').val(data.price);
                    $('[name="price_perUnit"]').val(data.price_perUnit);
                    $('[name="stok"]').val(data.stok);
                    $('[name="stok_update"]').val(data.stok_update);
                    $('[name="price_update"]').val(data.price_update);
                    $('[name="kode_budget"]').val(data.kode_budget);
                    $('[name="ket"]').val(data.ket);
                    $('[name="price_perUnit_upd"]').val(data.price_perUnit_upd);
                    $('[name="peruntukan"]').val(data.peruntukan);
                    // $('[name="departemen"]').val(data.departemen);

                    //split budget
                    // $('[name="split"]').val(data.split);
                    // $('[name="split-budget"]').val(data.split_budget);
                }
            });
        }
    }
</script>

<!-- script untuk import data excel -->
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



<!-- script untuk membuat stock menyesuaikan dengan price per unit -->
<script>
    function updateStok() {
        var budget = $('#price').val();
        var pricePerUnit = $('#price_perUnit').val();

        if (budget && pricePerUnit) {
            var stok = (budget / pricePerUnit).toFixed(2);
            $('#stok').val(stok);
        }
    }

    function updatePrice() {
        var budget = $('#price').val();
        var stok = $('#stok').val();

        if (budget && stok) {
            var pricePerUnit = (budget / stok).toFixed(2);
            $('#price_perUnit').val(pricePerUnit);
        }
    }

    function confirmChanges() {
        alert("Perubahan berhasil dikonfirmasi!");
    }
</script>

<!--  -->

<!-- Script untuk mengambil stock -->

<script>
    var originalStokValue; // Menyimpan nilai stok sebelum perubahan

    function updateAmbilBudget() {
        var price = parseFloat(document.getElementById('ambil-price').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('ambil-price_perUnit').value) || 0;
        var stok = parseFloat(document.getElementById('ambil-stok').value) || 0;

        // Validasi agar price_perUnit tidak melebihi batas stok
        var maxPricePerUnit = price / stok;
        if (price_perUnit > maxPricePerUnit) {
            document.getElementById('ambil-price_perUnit').value = maxPricePerUnit;
            price_perUnit = maxPricePerUnit;
        }

        var budget = price - price_perUnit;
        document.getElementById('budget').value = budget;
    }

    function confirmUpdateAmbilStok() {
        console.log('confirmUpdateStok called');
        var stokElement = document.getElementById('ambil-stok');
        originalStokValue = parseFloat(stokElement.value) || 0; // Simpan nilai stok sebelum perubahan

        var confirmation = document.getElementById('confirmation-message');
        confirmation.innerHTML = "Anda akan mengurangi stok. Lanjutkan?";
        confirmation.style.display = 'block';
    }

    function updateAmbilStok() {
        var stok = parseFloat(document.getElementById('ambil-stok').value) || 0;
        var price_perUnit = parseFloat(document.getElementById('ambil-price_perUnit').value) || 0;
        var newPrice = stok * price_perUnit;
        var currentPrice = parseFloat(document.getElementById('ambil-price').value) || 0;

        if (newPrice < currentPrice) {
            document.getElementById('ambil-price').value = newPrice;
            updateAmbilBudget();
        } else {
            document.getElementById('ambil-stok').value = Math.ceil(currentPrice / price_perUnit);
        }
    }

    function proceedUpdateAmbilStok() {
        var confirmation = confirm("Anda yakin akan mengurangi stok?");

        if (confirmation) {
            console.log('User pressed OK');
            updateAmbilStok();
            closeConfirmation();
        } else {
            console.log('User pressed Cancel');
        }
    }

    function closeConfirmation() {
        document.getElementById('confirmation-message').style.display = 'none';
        document.getElementById('ambil-stok').value = originalStokValue; // Kembalikan nilai stok jika pengguna menekan Cancel
    }
</script>

<!-- script untuk ambil stok -->
<script>
    function konfirmasiPenambahanStok() {
        var jumlahStokInput = document.getElementById('ambil-stok');
        var jumlahAmbilStokInput = document.getElementById('jumlah-ambil-stok');

        // Mendapatkan nilai jumlah stok dari input
        var jumlahStok = parseFloat(jumlahStokInput.value);

        // Mendapatkan nilai jumlah stok yang akan diambil
        var jumlahAmbilStok = parseFloat(jumlahAmbilStokInput.value);

        // Memastikan bahwa jumlah yang diambil tidak melebihi jumlah stok yang tersedia
        if (jumlahAmbilStok <= jumlahStok) {
            // Mengurangkan jumlah stok dengan jumlah yang diambil
            jumlahStok -= jumlahAmbilStok;

            // Memperbarui nilai input jumlah stok
            jumlahStokInput.value = jumlahStok.toFixed(1); // Menampilkan satu angka desimal

            // Menampilkan pesan konfirmasi (optional)
            var confirmationMessage = document.getElementById('confirmation-message');
            confirmationMessage.innerHTML = 'Stok berhasil dikurangkan.';
            confirmationMessage.style.display = 'block';
        } else {
            // Menampilkan pesan error jika jumlah yang diambil melebihi jumlah stok yang tersedia
            alert('Jumlah stok yang diambil melebihi stok yang tersedia.');
        }
    }
</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Import Budget <?= strtoupper($_SESSION['fullname']); ?></h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <!-- <form action="<?= base_url(); ?>process/import.php" method="post" enctype="multipart/form-data">
                <input class="btn btn-primary btn-icon-split btn-sm" type="file" name="excel_file">
                <input class="btn btn-primary btn-icon-split btn-sm" type="submit" value="Import">
            </form> -->

            <?php if ($_SESSION['level'] == 'admin') { ?>
                <input type="file" id="excelFile" class="">

                <button onclick="importData()" class="btn btn-primary btn-icon-split btn-sm">Import</button>

            <?php }; ?>



        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-white text-center" style="background-color: #7C93C3;">
                        <tr>
                            <th width="10">NO</th>
                            <th width="20">KODE BUDGET</th>
                            <th>WAKTU</th>
                            <th>PERUSAHAAN</th>
                            <th>KATEGORI</th>
                            <th width="500">DESKRIPSI</th>
                            <th>PERUNTUKAN</th>
                            <th>UNIT/SATUAN</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th width="200">UNIT PRICE</th>
                                <!-- <th width="200">SELISIH BERKURANG</th> -->
                                <th>QTY BF</th>
                                <th>QTY</th>
                                <th width="200">BGT BF</th>
                                <th width="200">BGT</th>
                            <?php endif; ?>


                            <?php if ($_SESSION['level'] == 'user') : ?>
                                <th>QTY BF</th>
                                <th>QTY</th>
                                <th width="50">Ubh Price Unit</th>
                                <th width="50">Ambil Stok</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT * FROM prodev  ORDER BY idbarang ASC") or die(mysqli_error($con));
                        // $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang ASC") or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($query)) :

                            //code untuk melihat selisih transaksi price per unit
                            $priceAwal = $row['price_perUnit_upd'];
                            $priceKurang = $row['price_perUnit'];
                            $selisihPirceUnit = $priceAwal - $priceKurang;
                        ?>
                            <tr>

                                <td><?= $n++; ?></td>

                                <td><?= $row['kode_budget']; ?></td>

                                <td><?= $row['waktu_input']; ?></td>

                                <td><?= $row['perusahaan']; ?></td>

                                <td><?= $row['kategori']; ?></td>

                                <td><?= $row['deskripsi']; ?></td>

                                <td><?= $row['peruntukan']; ?></td>

                                <td><?= $row['satuanUnit']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= number_format($row['price_perUnit'], 0, ',', '.'); ?></td>
                                    <!-- <td>Rp. <?= number_format($selisihPirceUnit, 0, ',', '.'); ?></td> -->
                                <?php endif; ?>

                                <td><?= $row['stok_update']; ?></td>

                                <td><?= $row['stok']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= number_format($row['price_update'], 0, ',', '.'); ?></td>
                                <?php endif; ?>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= number_format($row['price'], 0, ',', '.'); ?></td>

                                <?php endif; ?>


                                <?php if ($_SESSION['level'] == 'user') : ?>
                                    <td>
                                        <a href="#barangModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                        <!-- <a href="<?= base_url(); ?>/process/barang.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['idbarang']); ?>" class="btn btn-sm btn-circle btn-danger btn-hapus"><i class="fas fa-trash"></i></a> -->
                                    </td>
                                    <td>
                                        <a href="#ambilStock" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-primary"><i class="fas fa-edit"></i></a>
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

<!-- Modal Ubah Price Unit -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                    <h5>Kode Budget - <input type="text" name="kode_budget" style="border: 0;"></h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">

                                <input type="hidden" name="idbarang" class="form-control">
                                <input type="hidden" name="kode_budget" class="form-control">
                                <input type="hidden" name="departemen" class="form-control">
                                <input type="hidden" name="stok_update" class="form-control">
                                <input type="hidden" name="price_perUnit_upd" class="form-control">
                                <input type="hidden" name="trnsk" value="price" class="form-control">

                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="price">Budget:</label>
                                        <input type="number" class="form-control" name="price" id="price" onchange="" readonly>
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <label for="price_perUnit">Price Per Unit:</label>
                                        <input type="number" class="form-control" name="price_perUnit" id="price_perUnit" onchange="updateStok()" require>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label for="stok">Qty:</label>
                                        <input type="text" class="form-control" name="stok" id="stok" oninput="updatePrice()" readonly>
                                    </div>
                                    <div class="col-md-6 mt-5">
                                        <a class="btn btn-primary" onclick="confirmChanges()"><span style="color: white;">Ubah</span></a>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- ini nanti akan di ganti dengan get data dari excel -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="merek_id">Perusahaan :</label> -->
                                <select name="merek_id" id="merek_id" class="form-select select2" style="width:100%;" hidden>
                                    <option value="">-- Deskripsi Barang --</option>
                                    <?= list_merek(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="merek_id">Kategori :</label> -->
                                <select name="kategori_id" id="kategori_id" class="form-select select2" style="width:100%;" hidden>
                                    <option value="">-- Kategori Barang --</option>
                                    <?= list_kategori(); ?>
                                </select>
                            </div>
                        </div>
                        <!-- // -->


                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Wajib di isi) <span class="text-danger">*</span></label>
                                <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" require></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
            <br>
            <div class="container">
                <p><i>Sebelum anda mengurangi atau menambahkan price per unit, Periksalah kembali apakah data yang anda masukan itu sudah benar !!. <span style="color: red"> Jika ada kendala hubungi Admin !!</span></i></p>
            </div>
        </div>
    </div>
</div>





<!-- Modal Ambil Stock -->


<div class="modal fade" id="ambilStock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->

                    <h5>Kode Budget - <input type="text" name="kode_budget" style="border: 0;"></h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">


                                <input type="hidden" name="idbarang" class="form-control">
                                <input type="hidden" name="kode_budget" class="form-control">
                                <input type="hidden" name="departemen" class="form-control">
                                <input type="hidden" name="stok_update" class="form-control">
                                <input type="hidden" name="trnsk" value="stok" class="form-control">


                                <div class="row">



                                    <div class="col-md-6">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi" readonly>
                                    </div>
                                    <!--  -->

                                    <div class="col-md-6">
                                        <label for="price">Budget:</label>
                                        <input type="number" class="form-control" name="price_display" readonly>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="price"><span style="color: red;">Budget Sisa:</span></label>
                                        <input type="number" class="form-control" name="price" id="ambil-price" onchange="updateAmbilBudget()" readonly>
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <label for="price_perUnit">Price Per Unit:</label>
                                        <input type="number" class="form-control" name="price_perUnit" id="ambil-price_perUnit" onchange="updateAmbilBudget()" readonly>
                                    </div>


                                    <div class="col-md-6 mt-2">
                                        <label for="stok">Stok:</label>


                                        <input type="number" step="0.1" class="form-control" name="stok" id="ambil-stok" oninput="confirmUpdateAmbilStok()" readonly>
                                        <div id="confirmation-message" style="display: none;"></div>

                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label for="stok">Jumlah stok yang di ambil:</label>

                                        <div id="confirmation-message" style="display: none;"></div>

                                        <input type="number" class="form-control" name="ambil_stok" id="jumlah-ambil-stok">

                                    </div>


                                    <!-- button 1 -->
                                    <div class="col-md-6 mt-4">
                                        <a class="btn btn-primary " style="color: white;" onclick="proceedUpdateAmbilStok()">Konfirmasi</a>
                                    </div>

                                    <!-- button 2 -->
                                    <div class="col-md-6 mt-4">
                                        <a class="btn btn-danger text-white" onclick="konfirmasiPenambahanStok()">Ambil</a>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div id="result"></div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- ini nanti akan di ganti dengan get data dari excel -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="merek_id">Perusahaan :</label> -->
                                <select name="merek_id" id="merek_id" class="form-select select2" style="width:100%;" hidden>
                                    <option value="">-- Deskripsi Barang --</option>
                                    <?= list_merek(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label for="merek_id">Kategori :</label> -->
                                <select name="kategori_id" id="kategori_id" class="form-select select2" style="width:100%;" hidden>
                                    <option value="">-- Kategori Barang --</option>
                                    <?= list_kategori(); ?>
                                </select>
                            </div>
                        </div>
                        <!-- // -->


                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Wajib di isi) <span class="text-danger">*</span></label>
                                <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" require></textarea>
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

            <br>
            <div class="container">
                <p><i>Sebelum anda mengurangi stok, Periksalah kembali apakah stok yang anda kurangi itu sudah benar !!. <span style="color: red">Stok tidak bisa di tambahkan kembali jika sudah di kurangi !!</span></i></p>
            </div>
        </div>
    </div>
</div>