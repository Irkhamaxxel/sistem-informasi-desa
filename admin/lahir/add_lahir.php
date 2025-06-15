<?php
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi ke database sudah ada
// Misalnya: $koneksi = new mysqli('host', 'user', 'password', 'database');

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
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Bayi" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tgl Lahir</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="tgl_lh" name="tgl_lh" required>
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
                <label class="col-sm-2 col-form-label">Keluarga</label>
                <div class="col-sm-6">
                    <select name="id_kk" id="id_kk" class="form-control select2bs4" required>
                        <option selected="selected">- Pilih KK -</option>
                        <?php
                        // Ambil data dari database
                        $query = "SELECT * FROM tb_kk";
                        $hasil = $koneksi->query($query);

                        if ($hasil) {
                            while ($row = $hasil->fetch_assoc()) {
                                echo "<option value='{$row['id_kk']}'>{$row['no_kk']} - {$row['kepala']}</option>";
                            }
                        } else {
                            echo "Error: " . $koneksi->error;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
                <a href="?page=data-lahir" title="Kembali" class="btn btn-secondary">Batal</a>
            </div>
        </div>
    </form>
</div>

<?php
// Proses simpan data jika tombol simpan ditekan
if (isset($_POST['Simpan'])) {
    $nama = $_POST['nama'];
    $tgl_lh = $_POST['tgl_lh'];
    $jekel = $_POST['jekel'];
    $id_kk = $_POST['id_kk'];

    // Simpan data ke tb_lahir
    $sql_simpan = "INSERT INTO tb_lahir (nama, tgl_lh, jekel, id_kk) VALUES (
        '$nama',
        '$tgl_lh',
        '$jekel',
        '$id_kk'
    )";

    $query_simpan = $koneksi->query($sql_simpan);

    if ($query_simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil', text: '', icon: 'success', confirmButtonText: 'OK'})
        .then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-lahir';
            }
        });
        </script>";
    } else {
        echo "Error: " . $koneksi->error;
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal', text: '', icon: 'error', confirmButtonText: 'OK'})
        .then((result) => {
            if (result.value) {
                window.location = 'index.php?page=add-lahir';
            }
        });
        </script>";
    }
}
?>
