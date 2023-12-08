<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">BUDGETING <sup>SCG</sup></div>
        <!-- <img src="<?= $base_url; ?>assets/img/Logo Sebuku.png" width="120" height="110"> -->
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Beranda -->
    <li class="nav-item <?= isset($home) ? 'active' : ''; ?>">
        <a class="nav-link" href="?#">
            <i class="fas fa-fw fa-home"></i>
            <span>Ddashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menu
    </div>
    <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'user') : ?>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= isset($master) ? 'active' : ''; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master" aria-expanded="true" aria-controls="master">
                <i class="fas fa-fw fa-folder"></i>
                <span>Budget Departemen</span>
            </a>
            <div id="master" class="collapse <?= isset($master) ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <a class="collapse-item <?= isset($merek) ? 'active' : ''; ?>" href="?merek">Perusahaan</a> -->
                    <!-- <a class="collapse-item <?= isset($kategori) ? 'active' : ''; ?>" href="?kategori">Kategori</a> -->

                    <?php if ($_SESSION['username'] == 'PRODEV' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($prodev) ? 'active' : ''; ?>" href="?prodev">PRODEV</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'CPP' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($cpp) ? 'active' : ''; ?>" href="?cpp">CPP</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'EA' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($ea) ? 'active' : ''; ?>" href="?ea">EA</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'HSE' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($hse) ? 'active' : ''; ?>" href="?hse">HSE</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'ITC' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($itc) ? 'active' : ''; ?>" href="?itc">ITC</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'MEP' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($mep) ? 'active' : ''; ?>" href="?mep">MEP</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'SCM' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($scm) ? 'active' : ''; ?>" href="?scm">SCM</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'SHIP' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($ship) ? 'active' : ''; ?>" href="?ship">SHIP</a>
                    <?php endif; ?>

                    <?php if ($_SESSION['username'] == 'SURVEY' || $_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($survey) ? 'active' : ''; ?>" href="?survey">SURVEY</a>
                    <?php endif; ?>

                    <!-- menu untuk super admin -->
                    <?php if ($_SESSION['level'] == 'admin') : ?>
                        <a class="collapse-item <?= isset($pengguna) ? 'active' : ''; ?>" href="?pengguna">Pengguna</a>
                    <?php endif; ?>
                    <!--  -->
                    <a class="collapse-item <?= isset($split) ? 'active' : ''; ?>" href="?split">Split Budget</a>

                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?= isset($transaksi) ? 'active' : ''; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true" aria-controls="transaksi">
                <i class="fas fa-fw fa-folder"></i>
                <span>Transaksi</span>
            </a>
            <div id="transaksi" class="collapse <?= isset($transaksi) ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <!-- <a class="collapse-item <?= isset($barang_masuk) ? 'active' : ''; ?>" href="?barang_masuk">Barang Masuk</a> -->
                    <a class="collapse-item <?= isset($trnsk_prodev) ? 'active' : ''; ?>" href="?trnsk_prodev">Transaksi Price</a>
                    <a class="collapse-item <?= isset($trnsk_stok) ? 'active' : ''; ?>" href="?trnsk_stok">Transaksi Stok</a>
                    <a class="collapse-item <?= isset($trnsk_split) ? 'active' : ''; ?>" href="?trnsk_split">Transaksi Split</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <!-- <li class="nav-item <?= isset($laporan) ? 'active' : ''; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="laporan">
                <i class="fas fa-fw fa-folder"></i>
                <span>Laporan</span>
            </a>
            <div id="laporan" class="collapse <?= isset($laporan) ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= isset($lap_barang_masuk) ? 'active' : ''; ?>" href="?lap_barang_masuk">Laporan
                        Barang Masuk</a>
                    <a class="collapse-item <?= isset($lap_barang_keluar) ? 'active' : ''; ?>" href="?lap_barang_keluar">Laporan
                        Barang Keluar</a>
                    <a class="collapse-item <?= isset($lap_stok_barang) ? 'active' : ''; ?>" href="<?= base_url(); ?>process/lap_stok_barang.php" target="_blank">Laporan Stok
                        Barang</a>
                </div>
            </div>
        </li> -->
        <li class="nav-item <?= isset($log_transaksi) ? 'active' : ''; ?>">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#log_transaksi" aria-expanded="true" aria-controls="log_transaksi">
                <i class="fas fa-fw fa-folder"></i>
                <span>Log Transaksi</span>
            </a>
            <div id="log_transaksi" class="collapse <?= isset($log_transaksi) ? 'show' : ''; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= isset($trnsk_berhasil) ? 'active' : ''; ?>" href="?trnsk_berhasil">Log Transaksi Berhasil</a>
                    <a class="collapse-item <?= isset($trnsk_gagal) ? 'active' : ''; ?>" href="?trnsk_gagal">Log Transaksi Gagal</a>
                </div>
            </div>
        </li>


    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->