<?php hakAkses(['admin', 'user']);

$now = date('Y-m-d'); ?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard </h1>
    </div>

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="float-left">Barang Masuk Hari Ini</h4>
            <a href="<?= base_url(); ?>process/cetak_barang_masuk_today.php" target="_blank" class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>TANGGAL</th>
                            <th>NAMA BARANG</th>
                            <th>MEREK</th>
                            <th>KATEGORI</th>
                            <th>KETERANGAN</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT x.*,x1.nama_barang,x2.nama_merek,x3.nama_kategori FROM barang_masuk x JOIN barang x1 ON x1.idbarang=x.barang_id JOIN merek x2 ON x2.idmerek=x1.merek_id JOIN kategori x3 ON x3.idkategori=x1.kategori_id WHERE x.tanggal='$now' ORDER BY x.idbarang_masuk DESC") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['nama_barang']; ?></td>
                                <td><?= $row['nama_merek']; ?></td>
                                <td><?= $row['nama_kategori']; ?></td>
                                <td><?= $row['keterangan']; ?></td>
                                <td><?= $row['jumlah']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

    <!-- DataTales Example -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="float-left">Barang Keluar Hari Ini</h4>
            <a href="<?= base_url(); ?>process/cetak_barang_keluar_today.php" target="_blank" class="btn btn-info btn-icon-split btn-sm float-right">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">Cetak</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="20">NO</th>
                            <th>TANGGAL</th>
                            <th>NAMA BARANG</th>
                            <th>MEREK</th>
                            <th>KATEGORI</th>
                            <th>KETERANGAN</th>
                            <th>JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 1;
                        $query = mysqli_query($con, "SELECT x.*,x1.nama_barang,x2.nama_merek,x3.nama_kategori FROM barang_keluar x JOIN barang x1 ON x1.idbarang=x.barang_id JOIN merek x2 ON x2.idmerek=x1.merek_id JOIN kategori x3 ON x3.idkategori=x1.kategori_id WHERE x.tanggal='$now' ORDER BY x.idbarang_keluar DESC") or die(mysqli_error($con));
                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $n++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= $row['nama_barang']; ?></td>
                                <td><?= $row['nama_merek']; ?></td>
                                <td><?= $row['nama_kategori']; ?></td>
                                <td><?= $row['keterangan']; ?></td>
                                <td><?= $row['jumlah']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> -->
    <!-- /.container-fluid -->

    <!-- dashboard PRODEV -->
    <div class="card card-solid">
        <div class="card-body pb-0">
            <div class="row">

                <?php if ($_SESSION['username'] == 'PRODEV' || $_SESSION['level'] == 'admin') : ?>
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                        <div class="card bg-light d-flex flex-fill">
                            <div style="background-color:#29ADB2" class="card-header text-muted border-bottom-0 text-center">
                                <h4 class="text-white"> <b>TRANSAKSI TERBARU</b></h4>
                            </div>
                            <div class="card-body pt-0 mt-2">
                                <div class="row">
                                    <div class="col-12">

                                        <?php
                                        $queryTotal = mysqli_query($con, "SELECT SUM(price_update) as total_price FROM prodev") or die(mysqli_error($con));
                                        $queryTersisa = mysqli_query($con, "SELECT SUM(price) as total_tersisa FROM prodev") or die(mysqli_error($con));


                                        $resultTotal = mysqli_fetch_assoc($queryTotal);
                                        $totalPrice = $resultTotal['total_price'];

                                        $resultTersisa = mysqli_fetch_assoc($queryTersisa);
                                        $totalBudget = $resultTersisa['total_tersisa'];

                                        // $budgetTersisa = $totalBudget - $totalPrice;
                                        ?>
                                        <?php if ($_SESSION['level'] == 'admin') { ?>
                                            <h5 class="text-muted text-sm"><b>Total Budget : Rp. <?= number_format($totalPrice, 0, ',', '.'); ?></b></h5>
                                            <h6 class="text-muted text-sm"><b>Budget Tersisa : Rp. <?= number_format($totalBudget, 0, ',', '.'); ?></b></h6>
                                            <hr>
                                        <?php }; ?>

                                        <?php
                                        $i = 1;
                                        $query = mysqli_query($con, "SELECT x.*,x1.keterangan,x2.nama_kategori FROM trnsk_prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC LIMIT 4") or die(mysqli_error($con));

                                        if (mysqli_num_rows($query) > 0) {

                                            while ($row = mysqli_fetch_array($query)) :
                                        ?>

                                                <ul class="ml-1 mb-0 fa-ul text-muted">
                                                    <hr>
                                                    <li class="small"><b>Kode : </b> <?= $row['kode_budget']; ?></li>
                                                    <li class="small"><b>Deskripsi : </b> <?= $row['deskripsi']; ?></li>
                                                    <!-- <li class="small"><b>Jumlah Stok : </b> <?= $row['stok_update']; ?></li> -->
                                                    <li class="small"><b>Sisa Stok : </b> <?= $row['stok']; ?></li>
                                                    <li class="small"><b>Tanggal : </b> <?= $row['waktu_trnsk'] ?></li>
                                                    <hr>
                                                </ul>

                                        <?php endwhile;
                                        } else {
                                            echo '
                                            <tr>
                                            <td class="text-center" colspan="7">Belum Ada Transaksi Yang Terjadi</td>
                                            </tr>';
                                        }
                                        ?>

                                    </div>
                                    <!-- <div class="col-5 text-center">
                                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                                </div> -->
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <a href="?trnsk_prodev" class="btn btn-sm btn-primary">
                                        <!-- <i class="fas fa-user"></i> View Profile -->
                                        View Detail Log
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- informasi -->
                    <?php if ($_SESSION['username'] == 'PRODEV') : ?>

                        <ul class="list-group col-4">
                            <li class="list-group-item" style="background-color: #7C93C3;">
                                <h4 class="text-center text-white"><b>BUDGET <?= strtoupper($_SESSION['fullname']); ?></b></h4>
                            </li>
                            <li class="list-group-item">
                                <h6 class="text-muted text-sm">Total Budget : <b>Rp. <?= number_format($totalPrice, 0, ',', '.'); ?></b></h6>
                                <h5 class="text-muted text-sm">Budget Tersisa : <b>Rp. <?= number_format($totalBudget, 0, ',', '.'); ?></>
                                </h5>
                            </li>

                        </ul>


                    <?php endif; ?>
                    <!-- // -->
                <?php endif; ?>





            </div>
        </div>
        <!-- /.card-body -->


    </div>