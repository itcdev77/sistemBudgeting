<?php hakAkses(['admin', 'user']); ?>


<script>
    function submit(x) {
        if (x == 'add') {
            // kosong
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
                            <th width="20">KODE BUDGET</th>
                            <th>WAKTU TRANSAKSI</th>
                            <th>DEPARTEMEN</th>
                            <th>DESKRIPSI</th>
                            <th>KETERANGAN</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th>QTY SISA</th>
                                <th width="100">BGT SISA</th>
                            <?php endif; ?>


                            <?php if ($_SESSION['level'] == 'user') : ?>
                                <!-- <th>QTY BF</th> -->
                                <th>QTY SISA</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $query = mysqli_query($con, "SELECT * FROM barang  ORDER BY idbarang DESC") or die(mysqli_error($con));
                        $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM trnsk_prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) :

                        ?>
                                <tr>
                                    <td><a href="#detailModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)"><?= $row['kode_budget']; ?></a></td>
                                    <td><?= $row['waktu_trnsk']; ?></td>
                                    <td><?= $row['departemen']; ?></td>
                                    <td><?= $row['deskripsi']; ?></td>

                                    <td><?= $row['ket']; ?></td>

                                    <td><?= $row['stok']; ?></td>


                                    <?php if ($_SESSION['level'] == 'admin') : ?>
                                        <td>Rp. <?= $row['price']; ?></td>
                                    <?php endif; ?>



                                </tr>
                        <?php endwhile;
                        } else {
                            echo '
                            <tr>
                            <td class="text-center" colspan="7">Belum Ada Transaksi Yang Terjadi</td>
                            </tr>';
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
                                        <label for="deskripsi">Deskripsi:</label>
                                        <input width="20" type="text" class="form-control" name="deskripsi" id="deskripsi" readonly>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="price"><span style="color: red;">Budget :</span></label>
                                        <input type="number" class="form-control" name="price" id="ambil-price" readonly>
                                    </div>

                                    <div class="col-md-2 mt-2">
                                        <label for="stok">Stok:</label>

                                        <div id="confirmation-message" style="display: none;"></div>

                                        <input type="number" class="form-control text-center" name="stok" id="ambil-stok" readonly>

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