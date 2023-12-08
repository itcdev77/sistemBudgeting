<?php hakAkses(['admin', 'user']);

include('./config/conn.php');

?>


<script>
    function submit(x) {
        if (x == 'add') {
            $('[name="deskripsi"]').val("");
            $('[name="merek_id"]').val("").trigger('change');
            $('[name="kategori_id"]').val("").trigger('change');

            $('[name="kode_budget"]').val("");
            $('[name="ket"]').val("");
            $('[name="dapartemen"]').val("");

            //insert jenis transaksi

            $('[name="trnsk"]').val("");

            // $('#barangModal .modal-title').html('Tambah Barang');
            $('[name="ubah"]').hide();
            $('[name="tambah"]').show();
        } else {
            $('#split .modal-title').html('Action Tambah Barang');
            $('[name="tambah"]').hide();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_prodev.php',
                dataType: 'json',
                success: function(data) {

                    // var formattedPrice = 'Rp. ' + data.price;

                    // $('[name="idbarang"]').val(data.idbarang);
                    $('[name="merek_id"]').val(data.merek_id).trigger('change');
                    $('[name="kategori_id"]').val(data.kategori_id).trigger('change');
                    $('[name="deskripsi"]').val(data.deskripsi);
                    $('[name="kode_budget"]').val(data.kode_budget);
                    $('[name="ket"]').val(data.ket);
                    $('[name="departemen"]').val(data.departemen);
                    // $('[name="waktu_input"]').val(data.waktu_input);

                    //untuk update di table transaksi barang
                    $('[name="trnsk"]').val(data.waktu_trnsk);

                    //split budget
                    // $('[name="split"]').val(data.split);
                    // $('[name="split-budget"]').val(data.split_budget);
                }
            });
        }
    }
</script>

<!-- scrip untuk mengirim data split budget -->
<script>
    function submit(x) {
        if (x == 'add') {
            $('[name="deskripsi"]').val("");
            $('[name="deskripsi2"]').val("");
            $('[name="kode_budget"]').val("");
            $('[name="price_bgt"]').val("");
            $('[name="price_perUnit"]').val("");
            $('[name="qty_test1"]').val("");
            $('[name="kode_budget2"]').val("");
            $('[name="bgt_price"]').val("");
            $('[name="price_perUnit2"]').val("");
            $('[name="qty_test"]').val("");
            $('[name="ambilBudget"]').val("");
            $('[name="price_budget"]').val("");
            $('[name="split2"]').val("");
            $('[name="ket"]').val("");

            // $('#barangModal .modal-title').html('Tambah Barang');
            $('[name="ubah"]').hide();
            $('[name="tambah_split"]').show();
        } else {
            $('#split .modal-title').html('Action Tambah Barang');
            $('[name="tambah"]').hide();
            $('[name="ubah"]').show();

            $.ajax({
                type: "POST",
                data: {
                    id: x
                },
                url: '<?= base_url(); ?>process/view_prodev.php',
                dataType: 'json',
                success: function(data) {

                    //    kosong

                }
            });
        }
    }
</script>

<div class="container-fluid">

    <div class="card">
        <div class="card-body shadow mb-4">

            <div class="container">
                <div class="d-sm-flex align-items-center justify-content-center mb-4 text-center">

                    <h1 class="h3 mb-0 text-gray-800 text-center">REQUEST SPLIT BUDGET <?= strtoupper($_SESSION['fullname']); ?></h1>

                </div>
                <!-- open form split -->
                <form action="<?= base_url(); ?>process/act_prodev.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="form-group">


                                <div class="row">

                                    <!-- form split budget -->

                                    <!-- Kode budget -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="merek_id">Pilih barang :</label>
                                            <select class="form-control select2" type="text" name="deskripsi1" id="deskripsi_budget" required>
                                                <?php

                                                // Menghubungkan ke database
                                                $koneksi = mysqli_connect("localhost", "root", "password", "inventaris");

                                                // Periksa koneksi
                                                if (!$koneksi) {
                                                    die("Koneksi ke database gagal: " . mysqli_connect_error());
                                                }

                                                $sau = "SELECT * FROM prodev ORDER BY deskripsi ASC";
                                                $query2 = mysqli_query($con, "$sau") or die('mysql_error');

                                                // Loop melalui hasil query dan membuat pilihan dropdown
                                                echo '<option value="">-- Pilih Barang --</option>';
                                                while ($user_data = mysqli_fetch_array($query2)) {
                                                    echo '<option value="' . $user_data['deskripsi'] . '">' . $user_data['deskripsi'] . ' / ' . $user_data['kode_budget'] . '</option>';
                                                }
                                                //
                                                echo 'error';

                                                // Tutup koneksi ke database
                                                mysqli_close($koneksi);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- input untuk split budget -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="merek_id">Split dengan :</label>
                                            <select class="form-control select2" type="text" name="deskripsi2" id="split1" required>
                                                <?php

                                                // Menghubungkan ke database
                                                $koneksi = mysqli_connect("localhost", "root", "password", "inventaris");

                                                // Periksa koneksi
                                                if (!$koneksi) {
                                                    die("Koneksi ke database gagal: " . mysqli_connect_error());
                                                }

                                                $sau = "SELECT * FROM prodev ORDER BY deskripsi ASC";
                                                $query2 = mysqli_query($con, "$sau") or die('mysql_error');

                                                // Loop melalui hasil query dan membuat pilihan dropdown
                                                echo '<option value="">-- Pilih Barang --</option>';
                                                while ($user_data = mysqli_fetch_array($query2)) {
                                                    echo '<option value="' . $user_data['deskripsi'] . '">' . $user_data['deskripsi'] . ' / ' . $user_data['kode_budget'] . '</option>';
                                                }
                                                //
                                                echo 'error';

                                                // Tutup koneksi ke database
                                                mysqli_close($koneksi);
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- jumlah budget dan stok 1 -->
                                    <div class="col-md-6 mt-3">
                                        <ul class="list-group">
                                            <label for="deskripsi"><b>Detail Barang 1 :</b></label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Code :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">BGT :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_bgt" id="price_bgt" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">Price UNT :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit" id="price_perUnit" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">QTY :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="qty_test1" id="qty_test1" readonly>
                                                </div>
                                            </li>

                                            <!-- <p class="mt-2" style="color:orange;">Disini nanti mau di taru alert split budget berhasil !!! </p> -->

                                            <!-- button untuk membuka modal -->
                                            <a href="#split" data-toggle="modal" class="btn btn-primary btn-sm col-3 text-white mt-3"><b>+</b> Barang</a>
                                            <p class="mt-2" style="font-size: 11px;"><i>( Fitur untuk menambah barang yang tidak ada di budget )</i></p>
                                        </ul>
                                    </div>




                                    <!-- jumlah budget dan stok 2 -->


                                    <div class="col-md-6 mt-3">
                                        <ul class="list-group">
                                            <label for="deskripsi"><b>Detail Barang 2 :</b></label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">Code :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget2" id="kode_budget2" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">BGT :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="bgt_price" id="bgt_price" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">Price UNT :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit2" id="price_perUnit2" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">QTY :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="qty_test" id="qty_test" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <a class="btn btn-primary input-group-text" id="ambilBGT"><span><b>Ambil BGT</b></span></a>
                                                    </div>
                                                    <input type="number" class="form-control " name="ambilBudget" id="ambilBudget">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- detail transaksi -->
                                    <div class="col-md-6 mt-3">
                                        <ul class="list-group">
                                            <label for="deskripsi"><b>Detail Transaksi :</b></label>

                                            <li class="list-group-item border-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">(BGT) Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_budget" id="price_budget" readonly>
                                                </div>
                                                <hr>
                                            </li>
                                            <!-- selisih 1 -->
                                            <!-- <li class="list-group-item border-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">(BGT Terkurang) Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="selisih" readonly>
                                                </div>
                                                <hr>
                                            </li> -->
                                            <p class="mt-2"><i>( Detail Transaksi 1 )</i></p>

                                        </ul>
                                    </div>

                                    <div class="col-md-6 mt-5">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">(BGT) Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="split2" id="split2" readonly>
                                                </div>
                                                <hr>
                                            </li>
                                            <!-- selisih 2 -->
                                            <!-- <li class="list-group-item border-0">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">(BGT di Ambil) Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="selisih" readonly>
                                                </div>
                                                <hr>
                                            </li> -->
                                            <p class="mt-2"><i>( Detail Transaksi 2 )</i></p>

                                        </ul>
                                    </div>

                                    <!-- <div class="col-md-6 mt-3">
                                        <ul class="list-group">
                                            <label for="deskripsi"><b>test :</b></label>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="" readonly>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>

                                    <div class="col-md-6 mt-5">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text border-0">Rp :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="" readonly>
                                                </div>
                                            </li>


                                        </ul>
                                    </div> -->



                                    <!-- <div class="col-md-2">
                                <label for="deskripsi">QTY 2:</label>
                                <input width="20" type="number" class="form-control" name="deskripsi" id="deskripsi" readonly>
                            </div> -->


                                    <!-- end form -->

                                </div>

                            </div>
                        </div>

                        <!-- ini nanti akan di ganti dengan get data dari excel -->

                        <!-- // -->



                        <!-- keterangan untuk split budget -->
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Wajib di isi) <span class="text-danger">*</span></label>
                                <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>

                    </div>
                    <hr class="sidebar-divider">

                    <button class="btn btn-primary float-right" type="submit" name="tambah_split"><i class="fas fa-save"></i>
                        Request Split</button>

                </form>

            </div>
        </div>

    </div>
</div>

<!-- Modal Tambah Barang -->
<div class="modal fade" id="split" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLabel"></h5> -->
                    <h5>Action Tambah Barang</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">


                                <input type="hidden" name="departemen" class="form-control">
                                <input type="hidden" name="trnsk" value="barang" class="form-control">
                                <input type="hidden" name="departemen" value="<?= strtoupper($_SESSION['fullname']); ?>" class="form-control">

                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="deskripsi">Kode Budget:</label>
                                        <input width="20" type="text" class="form-control" name="kode_budget" id="deskripsi">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="deskripsi">Peruntukan:</label>
                                        <input width="20" type="text" class="form-control" name="peruntukan" id="deskripsi">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi">
                                    </div>


                                    <div class="col-md-6 mt-2">
                                        <label for="deskripsi">QTY:</label>
                                        <input width="20" type="number" class="form-control" name="stok" id="deskripsi">
                                    </div>


                                </div>






                            </div>
                        </div>

                        <!-- ini nanti akan di ganti dengan get data dari excel -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Perusahaan :</label>
                                <select name="merek_id" id="merek_id" class="form-select select2" style="width:100%;" hidden required>
                                    <option value="">-- Perusahaan --</option>
                                    <?= list_merek(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Kategori :</label>
                                <select name="kategori_id" id="kategori_id" class="form-select select2" style="width:100%;" hidden required>
                                    <option value="">-- Kategori Barang --</option>
                                    <?= list_kategori(); ?>
                                </select>
                            </div>
                        </div>
                        <!-- // -->


                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="keterangan">Keterangan (Wajib di isi) <span class="text-danger">*</span></label>
                                <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><b>+</b>
                        Tambah</button>
                </div>
            </form>
            <br>
            <!-- <div class="container">
                <p><i><span style="color: red">Kode Budget akan otomatis dibuat saat anda menambahkan barang !!</span></i></p>
            </div> -->
        </div>
    </div>
</div>