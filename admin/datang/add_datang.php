<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Tambah Data</h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama_datang" name="nama_datang" placeholder="Nama Pendatang" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-3">
                    <select name="jekel" id="jekel" class="form-control">
                        <option>- Pilih -</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tgl Datang</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="tgl_datang" name="tgl_datang" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pelapor</label>
                <div class="col-sm-6">
                    <select name="pelapor" id="pelapor" class="form-control select2bs4" required>
                        <option selected="selected">- Pilih Penduduk -</option>
                        <?php
                        // ambil data dari database
                        $query = "SELECT * FROM tb_pdd WHERE status='Ada'";
                        $hasil = mysqli_query($koneksi, $query);
                        while ($row = mysqli_fetch_array($hasil)) {
                        ?>
                        <option value="<?php echo $row['id_pend'] ?>">
                            <?php echo $row['nik'] . ' - ' . $row['nama'] ?>
                        </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
            <a href="?page=data-datang" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['Simpan'])) {
    // Ambil data dari form
    $nik = $_POST['nik'];
    $nama_datang = $_POST['nama_datang'];
    $jekel = $_POST['jekel'];
    $tgl_datang = $_POST['tgl_datang'];
    $pelapor = $_POST['pelapor'];

    // Cek apakah NIK sudah ada di tb_pdd
    $query_check_pdd = "SELECT id_pend FROM tb_pdd WHERE nik = '$nik'";
    $result_check_pdd = $koneksi->query($query_check_pdd);

    if ($result_check_pdd->num_rows > 0) {
        // Jika sudah ada, ambil id_pend
        $row_check_pdd = $result_check_pdd->fetch_assoc();
        $id_pdd = $row_check_pdd['id_pend'];
    } else {
        // Jika belum ada, tambahkan ke tb_pdd
        $query_add_pdd = "INSERT INTO tb_pdd (nik, nama, jekel, tgl_lh) VALUES ('$nik', '$nama_datang', '$jekel', '$tgl_datang')";
        $result_add_pdd = $koneksi->query($query_add_pdd);

        if ($result_add_pdd) {
            $id_pdd = $koneksi->insert_id;
        } else {
            echo "<script>
            Swal.fire({title: 'Gagal Menambahkan Data ke tb_pdd', text: '', icon: 'error', confirmButtonText: 'OK'})
            .then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=add-datang';
                }
            });
            </script>";
            exit();
        }
    }

    // Simpan data ke tb_datang
    $sql_simpan = "INSERT INTO tb_datang (nik, nama_datang, jekel, tgl_datang, pelapor) VALUES (
        '$nik',
        '$nama_datang',
        '$jekel',
        '$tgl_datang',
        '$pelapor'
    )";
    
    $query_simpan = $koneksi->query($sql_simpan);
    mysqli_close($koneksi);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'})
        .then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-datang';
            }
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal', text: '', icon: 'error', confirmButtonText: 'OK'})
        .then((result) => {
            if (result.value) {
                window.location = 'index.php?page=add-datang';
            }
        });
        </script>";
    }
}
?>
