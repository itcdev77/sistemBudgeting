<?php hakAkses(['admin', 'user']); ?>
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
                            <th>DESKRIPSI</th>
                            <th>KETERANGAN</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th width="100">UNIT PRICE</th>
                                <th>QTY BF</th>
                                <th>QTY</th>
                                <th width="100">BGT BF</th>
                                <th width="100">BGT</th>
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
                                <td><?= $row['kode_budget']; ?></td>
                                <td><?= $row['waktu_trnsk']; ?></td>
                                <td><?= $row['deskripsi']; ?></td>

                                <td><?= $row['ket']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price_perUnit']; ?></td>
                                <?php endif; ?>

                                <!-- <td><?= $row['stok_update']; ?></td> -->

                                <td><?= $row['stok']; ?></td>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price_update']; ?></td>
                                <?php endif; ?>

                                <?php if ($_SESSION['level'] == 'admin') : ?>
                                    <td>Rp. <?= $row['price']; ?></td>
                                <?php endif; ?>


                            </tr>
                        <?php endwhile; }
                        else {
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

<!-- Modal Tambah barang -->
