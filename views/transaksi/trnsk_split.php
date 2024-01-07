<?php hakAkses(['admin', 'user']);
?>


<script>
    function submit(x) {
        if (x == 'add') {
            // kosong
        } else {
            $('#detailModal .modal-title').html('Detail Transaksi Split Budget');
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

                    $('[name="idbarang"]').val(data.idbarang);
                    $('[name="merek_id"]').val(data.merek_id).trigger('change');
                    $('[name="kategori_id"]').val(data.kategori_id).trigger('change');
                    $('[name="deskripsi"]').val(data.deskripsi);
                    $('[name="deskripsi2"]').val(data.deskripsi2);
                    $('[name="price"]').val(data.price);
                    $('[name="price2"]').val(data.price2);
                    $('[name="stok"]').val(data.stok);
                    $('[name="stok2"]').val(data.stok2);
                    $('[name="kode_budget"]').val(data.kode_budget);
                    $('[name="kode_budget2"]').val(data.kode_budget2);
                    $('[name="ket"]').val(data.ket);
                    $('[name="departemen"]').val(data.departemen);
                    $('[name="stok_upd"]').val(data.stok_upd);
                    $('[name="stok_upd2"]').val(data.stok_upd2);
                    $('[name="waktu_trnsk"]').val(data.waktu_trnsk);
                    $('[name="trans_price1"]').val(data.trans_price1);
                    $('[name="trans_price2"]').val(data.trans_price2);
                    $('[name="jenis_trnsk"]').val(data.jenis_trnsk);
                    $('[name="price_perUnit"]').val(data.price_perUnit);
                    $('[name="price_perUnit2"]').val(data.price_perUnit2);
                    $('[name="split_price"]').val(data.split_price);

                    //split budget
                    // $('[name="split"]').val(data.split);
                    // $('[name="split-budget"]').val(data.split_budget);
                }
            });
        }
    }
</script>


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi Split Budget <?= strtoupper($_SESSION['fullname']); ?></h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <!-- <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#barang_keluar">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a> -->
            <!-- <a href="<?= base_url(); ?>process/cetak_barang_keluar.php" target="_blank" class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak</span>
            </a> -->
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10">NO</th>
                            <th width="100">KODE 1</th>
                            <th width="100">KODE 2</th>
                            <th>WAKTU TRANSAKSI</th>
                            <th>DEPARTEMEN</th>
                            <th>DESKRIPSI 1</th>
                            <th>DESKRIPSI 2</th>
                            <th>KETERANGAN</th>
                            <th>TRANSAKSI</th>
                            <th width="10" class="text-center">ACTION</th>

                            <!-- <?php if ($_SESSION['level'] == 'admin') : ?>
                            <?php endif; ?> -->

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        // $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM trnsk_prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));
                        $query = mysqli_query($con, "SELECT * FROM trnsk_prodev  ORDER BY idbarang ASC") or die(mysqli_error($con));

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) :

                                //rumus untuk melihat selisih stok keluar..
                                // $stokAwal = $row['stok_upd'];
                                // $stokKurang = $row['stok'];
                                // $selisihStok = $stokAwal - $stokKurang;

                                // Tambahkan kondisi untuk menentukan jenis transaksi yang ingin ditampilkan
                                $jenis_transaksi = "split"; // Ganti dengan "price" jika ingin menampilkan transaksi price
                                if ($row['jenis_trnsk'] == $jenis_transaksi && $row['departemen'] == $_SESSION['fullname'] || $_SESSION['level'] == 'admin' && $row['jenis_trnsk'] != 'price' && $row['jenis_trnsk'] != 'stok') :
                        ?>
                                    <tr>
                                        <td><?= $n++ ?></td>
                                        <td><a href="#detailModal2" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)"><?= $row['kode_budget']; ?></a></td>

                                        <td><?= $row['kode_budget2']; ?></td>
                                        <td><?= $row['waktu_trnsk']; ?></td>
                                        <td><?= $row['departemen']; ?></td>
                                        <td><?= $row['deskripsi']; ?></td>
                                        <td><?= $row['deskripsi2']; ?></td>
                                        <td><?= $row['ket']; ?></td>
                                        <td><?= $row['jenis_trnsk']; ?></td>

                                        <!-- approval system -->

                                        <?php if ($row['status'] == 'approved' && $_SESSION['level'] != 'admin') : ?>

                                            <!-- action untuk display detail transaksi -->
                                            <td class="text-center"><a href="#detailModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-primary"><i class="fas fa-edit"></i></a> <span class="text-primary">Approved</span></td>

                                        <?php endif; ?>

                                        <!-- status ketika sudah di approve -->
                                        <?php if ($row['status'] == 'approved' && $_SESSION['level'] == 'admin') : ?>

                                            <!-- action untuk display detail transaksi -->
                                            <td class="text-center" style="color: #65B741;"><i class="fas fa-check"></i></td>

                                        <?php endif; ?>
                                        <!--  -->
                                        
                                        <!-- status untuk user ketika belum ada action  dari FA -->
                                        <?php if ($row['status'] == NULL && $_SESSION['level'] != 'admin') : ?>

                                            <td class="text-center" style="color: orange;"><i class="fas fa-clock"></i> Pending</td>

                                        <?php endif; ?>
                                        <!--  -->
                                        
                                        <!-- action ketika status masih pending dan approval untuk admin -->
                                        <?php if ($row['status'] == NULL && $_SESSION['level'] == 'admin') : ?>

                                          <td class="text-center"><a class="btn btn-sm btn-circle btn-primary" href="#approve_split" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)"><i class="fas fa-edit"></i></a></td>

                                        <?php endif; ?>

                                        <!-- info yang akan muncul ketika transaksi gagal -->
                                        <?php if ($row['status'] == 'gagal') : ?>

                                            <td class="text-center" style="color: red;"><i class="fas fa-times"></i> Di Tolak</td>

                                        <?php endif; ?>


                                    </tr>
                        <?php
                                endif;
                            endwhile;
                        } else {
                            echo '<tr><td class="text-center" colspan="7">Belum Ada Transaksi Yang Terjadi</td></tr>';
                        }
                        ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Modal View Detail -->

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
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
                                <input type="hidden" name="kode_budget" class="form-control">


                                <div class="row">

                                    <div class="col col-6">
                                        <ul class="list-group">
                                            <label for="">Detail Barang 1</label>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Code 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Deskripsi 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="deskripsi" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT UNT 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">QTY :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="stok" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                    <div class="col col-6">
                                        <ul class="list-group">
                                            <label for="">Detail Barang 2</label>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Code 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Deskripsi 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="deskripsi2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT UNT 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">QTY 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="stok2" id="kode_budget" readonly>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>

                                    <div class="col col-6 mt-3">
                                        <ul class="list-group">
                                            <label for="">Detail Transaksi 1</label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-arrow-down" style="color: red"></i>Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="trans_price1" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-minus" style="color:#EF4040"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="split_price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col col-6 mt-3">
                                        <ul class="list-group">
                                            <label for="">Detail Transaksi 2</label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-arrow-up" style="color: green"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="trans_price2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-plus" style="color:#8ADAB2"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="split_price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col col-12 mt-3">
                                        <ul class="list-group">
                                            <label for="">Keterangan</label>
                                            <li class="list-group-item">
                                                <div class="input-group">

                                                    <input type="text" class="form-control border-0" name="ket" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

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
        </div>
    </div>
</div>


<!-- modal yang hanya bisa melihat detail -->
<div class="modal fade" id="detailModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
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
                                <input type="hidden" name="kode_budget" class="form-control">


                                <div class="row">

                                    <div class="col col-6">
                                        <ul class="list-group">
                                            <label for="">Detail Barang 1</label>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Code 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Deskripsi 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="deskripsi" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT UNT 1 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">QTY :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="stok" id="kode_budget" readonly>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                    <div class="col col-6">
                                        <ul class="list-group">
                                            <label for="">Detail Barang 2</label>

                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Code 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="kode_budget2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">Deskripsi 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="deskripsi2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">BGT UNT 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="price_perUnit2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0">QTY 2 :</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="stok2" id="kode_budget" readonly>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>

                                    <div class="col col-6 mt-3">
                                        <ul class="list-group">
                                            <label for="">Detail Transaksi 1</label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-arrow-down" style="color: red"></i>Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="trans_price1" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-minus" style="color:#EF4040"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="split_price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col col-6 mt-3">
                                        <ul class="list-group">
                                            <label for="">Detail Transaksi 2</label>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-arrow-up" style="color: green"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="trans_price2" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <div class="input-group-prepend ">
                                                        <span class="input-group-text border-0"><i class="fas fa-plus" style="color:#8ADAB2"></i> Rp.</span>
                                                    </div>
                                                    <input type="text" class="form-control border-0" name="split_price" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col col-12 mt-3">
                                        <ul class="list-group">
                                            <label for="">Keterangan</label>
                                            <li class="list-group-item">
                                                <div class="input-group">

                                                    <input type="text" class="form-control border-0" name="ket" id="kode_budget" readonly>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>


                    </div>


                </div>
            </form>
        </div>
    </div>
</div>


<!-- modal approval admin -->

<div class="modal fade" id="approve_split" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <!-- modal body -->
                <div class="modal-body">

                    <input type="hidden" name="trans_price1" class="form-control">
                    <input type="hidden" name="trans_price2" class="form-control">

                    <p class="text-center"><b>Silahkan pilih approve transaksi untuk setuju dan tolak untuk menolak transaksi</b></p>

                </div>

                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tolak</button>
                    <button class="btn btn-primary float-right" type="submit" name="ubah">
                        Approve</button>
                </div>

            </form>
        </div>
    </div>
</div>