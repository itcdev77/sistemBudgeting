<?php hakAkses(['admin']);

// $id = strtoupper($_SESSION['iduser']);
// $s = "select*from users where id='$_SESSION[iduser]'";
// $qu = mysqli_query($con, $s);
// $fe = mysqli_fetch_assoc($qu);

// $result = mysqli_query($con, "SELECT * FROM prodev WHERE id=$id");
// while ($user_data = mysqli_fetch_array($result)) {
//     $deskripsi = $user_data['deskripsi'];
// }

?>



<script>
    function submit(x) {
        if (x == 'add') {
            $('[name="nama_barang"]').val("");
            $('[name="merek_id"]').val("").trigger('change');
            $('[name="kategori_id"]').val("").trigger('change');
            $('[name="keterangan"]').val("");
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
                    $('[name="idbarang"]').val(data.idbarang);
                    $('[name="merek_id"]').val(data.merek_id).trigger('change');
                    $('[name="kategori_id"]').val(data.kategori_id).trigger('change');
                    $('[name="nama_barang"]').val(data.nama_barang);
                    $('[name="keterangan"]').val(data.keterangan);
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
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Import Budget PRODEV</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#" class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#barangModal" onclick="submit('add')">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Tambah</span>
            </a>

            <!-- <form action="<?= base_url(); ?>process/import.php" method="post" enctype="multipart/form-data">
                <input class="btn btn-primary btn-icon-split btn-sm" type="file" name="excel_file">
                <input class="btn btn-primary btn-icon-split btn-sm" type="submit" value="Import">
            </form> -->

            <input type="file" id="excelFile" class="">
            <!-- <input type="text" id="" class="" value="<?= strtoupper($_SESSION['iduser']); ?>" hidden> -->
            <button onclick="importData()" class="btn btn-primary btn-icon-split btn-sm">Import</button>

            <!-- <p><?= $user_data['deskripsi'] ?></p> -->


        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="10">KODE</th>
                            <th>WAKTU</th>
                            <th>DESKRIPSI</th>
                            <th>PERUNTUKAN</th>
                            <th>QTY</th>
                            <th width="100">PRICE</th>
                            <th width="50">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // $query = mysqli_query($con, "SELECT * FROM barang  ORDER BY idbarang DESC") or die(mysqli_error($con));
                        $query = mysqli_query($con, "SELECT x.*,x1.nama_merek,x2.nama_kategori FROM prodev x JOIN merek x1 ON x1.idmerek=x.merek_id JOIN kategori x2 ON x2.idkategori=x.kategori_id ORDER BY x.idbarang DESC") or die(mysqli_error($con));

                        while ($row = mysqli_fetch_array($query)) :
                        ?>
                            <tr>
                                <td><?= $i++; ?></td>

                                <td><?= $row['waktu_input']; ?></td>
                                <td><?= $row['deskripsi']; ?></td>
                                <td><?= $row['peruntukan']; ?></td>
                                <td><?= $row['stok']; ?></td>
                                <td>Rp. <?= $row['price']; ?></td>
                                <td>
                                    <a href="#barangModal" data-toggle="modal" onclick="submit(<?= $row['idbarang']; ?>)" class="btn btn-sm btn-circle btn-info"><i class="fas fa-edit"></i></a>
                                    <a href="<?= base_url(); ?>/process/barang.php?act=<?= encrypt('delete'); ?>&id=<?= encrypt($row['idbarang']); ?>" class="btn btn-sm btn-circle btn-danger btn-hapus"><i class="fas fa-trash"></i></a>
                                </td>
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
                                <label for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                <input type="hidden" name="idbarang" class="form-control">
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="merek_id">Merek Barang <span class="text-danger">*</span></label>
                                <select name="merek_id" id="merek_id" class="form-control select2" style="width:100%;" required>
                                    <option value="">-- Pilih Merek --</option>
                                    <?= list_merek(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori_id">Kategori Barang <span class="text-danger">*</span></label>
                                <select name="kategori_id" id="kategori_id" class="form-control select2" style="width:100%;" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?= list_kategori(); ?>
                                </select>
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
                    <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                        Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>