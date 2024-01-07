<?php hakAkses(['admin', 'user']); ?>


<script>
    function submit(x) {
        if (x == 'add') {
            // kosong
        } else {
            $('#detailModal .modal-title').html('Detail Transaksi Price Per Unit');
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
                    $('[name="price"]').val(data.price);
                    $('[name="stok"]').val(data.stok);
                    $('[name="kode_budget"]').val(data.kode_budget);
                    $('[name="ket"]').val(data.ket);
                    $('[name="departemen"]').val(data.departemen);
                    $('[name="stok_upd"]').val(data.stok_upd);
                    $('[name="di_ambil"]').val(data.di_ambil);
                    $('[name="waktu_trnsk"]').val(data.waktu_trnsk);

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
        <h1 class="h3 mb-0 text-gray-800">Detail Transaksi <?= strtoupper($_SESSION['fullname']); ?></h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10">NO</th>
                            <th width="20">KODE BUDGET</th>
                            <th>WAKTU TRANSAKSI</th>
                            <th>DEPARTEMEN</th>
                            <th>DESKRIPSI</th>
                            <th>KETERANGAN</th>
                            <th>TRANSAKSI</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th width="100">BGT SISA</th>
                            <?php endif; ?>

                            <th>PRICE UNIT</th>
                            <th>QTY BF</th>
                            <th>QTY UPD</th>

                            <th>SELISIH</th>
                            <th width="10" class="text-center">ACTION</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM trnsk_prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) :

                                //rumus untuk melihat selisih stok keluar..
                                $stokAwal = $row['stok_upd'];
                                $stokKurang = $row['stok'];
                                $selisihStok = $stokAwal - $stokKurang;

                                // Tambahkan kondisi untuk menentukan jenis transaksi yang ingin ditampilkan
                                $jenisTransaksi = "price"; // Ganti dengan "price" jika ingin menampilkan transaksi price
                                if ($row['jenis_trnsk'] == $jenisTransaksi || $row['departemen'] == $_SESSION['fullname'] && $_SESSION['level'] == 'admin') {
                        ?>
                                    <tr>
                                        <td><?= $n++ ?></td>
                                        <td><a href="#detailModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)"><?= $row['kode_budget']; ?></a></td>
                                        <td><?= $row['waktu_trnsk']; ?></td>
                                        <td><?= $row['departemen']; ?></td>
                                        <td><?= $row['deskripsi']; ?></td>
                                        <td><?= $row['ket']; ?></td>
                                        <td><?= $row['jenis_trnsk']; ?></td>

                                        <?php if ($_SESSION['level'] == 'admin') : ?>
                                            <td>Rp. <?= number_format($row['price'], 0, ',', '.'); ?></td>
                                        <?php endif; ?>

                                        <td>Rp. <?= number_format($row['price_perUnit'], 0, ',', '.'); ?></td>

                                        <td><?= $row['stok_upd']; ?></td>
                                        <td><?= $row['stok']; ?></td>

                                        <td><?= $selisihStok ?></td>
                                        
                                        <?php if ($row['status'] == 'approved') : ?>

                                        <!-- action untuk display detail transaksi -->
                                        <td class="text-center"><a href="#detailModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-primary"><i class="fas fa-edit"></i></a> <span class="text-primary">Approved</span></td>

                                        <?php endif; ?>

                                        <?php if ($row['status'] == 'approved' && $_SESSION['level'] == 'admin') : ?>

                                            <!-- action untuk display detail transaksi -->
                                            <td class="text-center" style="color: #65B741;"><i class="fas fa-check"></i></td>

                                        <?php endif; ?>

                                        <?php if ($row['status'] == NULL && $_SESSION['level'] != 'admin') : ?>

                                            <!-- action untuk display detail transaksi -->
                                            <td class="text-center" style="color: orange;"><i class="fas fa-clock"></i> Pending</td>

                                        <?php endif; ?>
                                        
                                        <!-- action untuk FA ketika ada transaksi yang masuk -->
                                        <?php if ($row['status'] == NULL && $_SESSION['level'] == 'admin') : ?>

                                            <td class="text-center"><a class="btn btn-sm btn-circle btn-primary" href="#detailModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)"><i class="fas fa-edit"></i></a></td>

                                        <?php endif; ?>

                                         <!-- info yang akan muncul ketika transaksi gagal -->
                                         <?php if ($row['status'] == 'gagal') : ?>

                                            <td class="text-center" style="color: red;"><i class="fas fa-times"></i> Di Tolak</td>

                                        <?php endif; ?>
                                    </tr>
                        <?php
                                };
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
                                    <div class="col-md-6">
                                        <label for="deskripsi">Kode Budget:</label>
                                        <input width="20" type="text" class="form-control" name="kode_budget" id="kode_budget" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi" readonly>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="price"><span style="color: red;">Budget :</span></label>
                                        <input type="number" class="form-control" name="price" id="ambil-price" readonly>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label for="stok">Qty Sebelumnya:</label>

                                        <input type="number" class="form-control text-center" name="stok_upd" id="ambil-stok" readonly>

                                    </div>
                                    <div class="col-md-2 mt-3">
                                        <label for="stok">Qty Update:</label>

                                        <input type="number" class="form-control text-center" name="stok" id="ambil-stok" readonly>

                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="stok">Jumlah Transaksi:</label>

                                        <input type="number" class="form-control text-center" name="di_ambil" id="di_ambil" readonly>

                                    </div>
                                    <div class="col-md-3 mt-3">
                                        <label for="stok">Waktu Transaksi:</label>

                                        <input type="text" class="form-control text-center" name="waktu_trnsk" id="waktu_trnsk" readonly>

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