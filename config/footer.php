<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Keluar</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body bg-danger text-white">Anda yakin ingin keluar dari aplikasi ?</div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-sm btn-danger" href="<?= base_url(); ?>process/logout.php"><i class="fas fa-sign-out-alt"></i>
                    Iya, Keluar</a>
            </div>
        </div>
    </div>
</div>
<!-- Ganti Password Modal-->
<div class="modal fade" id="gantiPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url(); ?>process/users.php?act=<?= encrypt('ganti_pass'); ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="text-black">Password Baru</label>
                        <input type="hidden" name="id" value="<?= $_SESSION['iduser']; ?>">
                        <input type="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-sm btn-success" type="submit" name="ubah_pass"><i class="fas fa-key"></i>
                        Ganti Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/jquery-mask/jquery-mask.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/select2/js/select2.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url(); ?>assets/js/demo/datatables-demo.js"></script>
<script src="<?= base_url(); ?>assets/js/demo/sweet-alert.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: "classic",
        });
        $('.uang').mask('000.000.000.000.000', {
            reverse: true
        });
    })
</script>

<!-- Include SweetAlert library (you can use a CDN) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.1/dist/sweetalert2.all.min.js"></script>


<!-- SCRIPT UNTUK FUNGSI SPLIT BUDGET -->

<!-- script untuk memilih barang yang akan mau di ambil budgetnya -->
<script>
    $(document).ready(function() {
        // Menangani perubahan pada pilihan barang
        $('#deskripsi_budget').change(function() {
            var merekId = $(this).val(); // Mengambil nilai merek_id yang dipilih

            // Mengambil base URL secara dinamis
            // var baseUrl = window.location.origin;

            // Mengirim permintaan AJAX
            $.ajax({
                type: 'POST',
                url: './views/master/get_budget.php',
                data: {
                    merek_id: merekId
                },
                dataType: 'json', // Menetapkan tipe data yang diharapkan
                success: function(response) {
                    // Menetapkan nilai harga ke input dengan id 'split2'
                    $('#price_budget').val(response.harga);

                    $('#price_bgt').val(response.Dharga);

                    // $('#price_budget').val(parseFloat(response.harga));


                    // Menetapkan nilai stok ke input dengan id 'qty_test'
                    $('#qty_test1').val(response.stok);

                    $('#kode_budget').val(response.kode_budget);

                    $('#price_perUnit').val(response.price_perUnit);

                }
            });
        });
    });
</script>

<!-- script untuk barang yang akan di split -->
<script>
    $(document).ready(function() {
        // Menangani perubahan pada pilihan barang
        $('#split1').change(function() {
            var merekId = $(this).val(); // Mengambil nilai merek_id yang dipilih

            // Mengirim permintaan AJAX
            $.ajax({
                type: 'POST',
                url: './views/master/get_budget2.php',
                data: {
                    merek_id: merekId
                },
                dataType: 'json', // Menetapkan tipe data yang diharapkan
                success: function(response) {
                    // Menetapkan nilai harga ke input dengan id 'split2'
                    $('#split2').val(parseFloat(response.harga));

                    $('#bgt_price').val(response.Dharga);

                    // Menetapkan nilai stok ke input dengan id 'qty_test'
                    $('#qty_test').val(response.stok); // Assuming stok is an integer

                    // Assuming kode_budget2 is a number, set its value
                    $('#kode_budget2').val(response.kode_budget2);

                    // Assuming price_perUnit2 is a number, set its value
                    $('#price_perUnit2').val(response.price_perUnit2);
                }
            });
        });
    });
</script>
<!--  -->

<!-- script untuk logic split budget -->


<script>
    $(document).ready(function() {
        // Menangani peristiwa ketika tombol "Ambil BGT" diklik
        $("#ambilBGT").click(function() {
            // Mendapatkan nilai dari input Ambil Budget
            var ambilBudgetValue = parseFloat($("#ambilBudget").val());

            // Validasi bahwa nilai yang dimasukkan adalah angka yang valid
            if (!isNaN(ambilBudgetValue)) {
                // konfirmasi untuk sweet alert...
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Anda yakin ingin mengambil budget ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mendapatkan nilai saat ini dari input BGT dengan id price_budget
                        var currentPriceBudgetValue = parseFloat($("#price_budget").val());

                        // Mengurangkan nilai Ambil Budget dari nilai saat ini di input BGT
                        var newPriceBudgetValue = currentPriceBudgetValue - ambilBudgetValue;

                        // Menambahkan nilai baru ke input BGT dengan id price_budget
                        $("#price_budget").val(newPriceBudgetValue);

                        // Mendapatkan nilai saat ini dari input BGT dengan id split2
                        var currentSplit2Value = parseFloat($("#split2").val());

                        // Menambahkan nilai Ambil Budget ke nilai saat ini di input BGT dengan id split2
                        var newSplit2Value = currentSplit2Value + ambilBudgetValue;

                        // Menambahkan nilai baru ke input BGT dengan id split2
                        $("#split2").val(newSplit2Value);

                        Swal.fire('Berhasil!', 'Budget telah diambil, Lihat detail transaksi.', 'success');
                    }
                });
            } else {
                // Menampilkan pesan kesalahan jika nilai yang dimasukkan bukan angka valid
                Swal.fire('Error', 'Masukkan angka yang valid.', 'error');
            }
        });
    });
</script>



<!-- end of logic split -->


<!-- END OF SCRIPT FUNGSI SPLIT BUDGET -->



<!-- vendor -->

<!-- AdminLTE App -->
<script src="../vendor/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../vendor/dist/js/demo.js"></script>

</body>

</html>