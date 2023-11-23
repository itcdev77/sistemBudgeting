<div class="container-fluid">


    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-center mb-4 text-center">

            <h1 class="h3 mb-0 text-gray-800 text-center">SPLIT BUDGET <?= strtoupper($_SESSION['fullname']); ?></h1>

        </div>
        <form action="<?= base_url(); ?>process/act_prodev.php" method="post">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="form-group">


                        <div class="row">

                            <!-- form split budget -->

                            <!-- Kode budget -->
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
                        <textarea name="ket" id="ket" cols="30" rows="5" class="form-control" require></textarea>
                    </div>
                </div>

            </div>
            <hr class="sidebar-divider">

            <button class="btn btn-primary float-right" type="submit" name="ubah"><i class="fas fa-save"></i>
                Split</button>

        </form>

    </div>
</div>