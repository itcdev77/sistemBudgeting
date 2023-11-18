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
                            <th>PERUNTUKAN</th>
                            <th>KETERANGAN</th>

                            <?php if ($_SESSION['level'] == 'admin') : ?>
                                <th width="100">UNIT PRICE</th>
                                <th>QTY BF</th>
                                <th>QTY</th>
                                <th width="100">BGT BF</th>
                                <th width="100">BGT</th>
                            <?php endif; ?>


                            <?php if ($_SESSION['level'] == 'user') : ?>
                                <th>QTY BF</th>
                                <th>QTY</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $query = mysqli_query($con, "SELECT * FROM barang  ORDER BY idbarang DESC") or die(mysqli_error($con));
                        $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM trnsk_prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $row['kode_budget']; ?></td>
                                <td><?= $row['waktu_trnsk']; ?></td>
                                <td><?= $row['deskripsi']; ?></td>

                                <td><?= $row['peruntukan']; ?></td>
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
<div class="modal fade" id="barang_keluar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/barang_keluar.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang Keluar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="barang_id">Nama Barang <span class="text-danger">*</span></label>
                                <select name="barang_id" id="barang_id" class="form-control select2" style="width:100%;" required>
                                    <option value="">-- Pilih Barang --</option>
                                    <?= list_barang(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="jumlah">Jumlah<span class="text-danger">*</span></label>
                                <input type="text" class="form-control uang" id="jumlah" name="jumlah" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="sidebar-divider">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fas fa-times"></i>
                        Batal</button>
                    <button class="btn btn-primary float-right" type="submit" name="tambah"><i class="fas fa-save"></i>
                        Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>