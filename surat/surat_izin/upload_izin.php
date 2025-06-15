<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Dokumen</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Upload Dokumen</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="fileUpload"><b>File Upload</b></label>
                        <input type="file" name="NamaFile" id="fileUpload" class="form-control-file">
                    </div>
                    <button type="submit" name="proses" class="btn btn-primary">Upload</button>
                </form>
                <?php
                include("inc/koneksi.php");

                if (isset($_POST['proses'])) {
                    $direktori = "surat/surat_izin/berkas/";
                    
                    // Cek dan buat direktori jika belum ada
                    if (!is_dir($direktori)) {
                        mkdir($direktori, 0777, true);
                    }

                    $file_name = $_FILES['NamaFile']['name'];
                    $file_path = $direktori . basename($file_name);

                    if (move_uploaded_file($_FILES['NamaFile']['tmp_name'], $file_path)) {
                        mysqli_query($koneksi, "INSERT INTO surat_izin (file) VALUES ('$file_name')");
                        echo "<b>File berhasil diupload</b>";
                    } else {
                        echo "<b>Gagal mengupload file</b>";
                    }
                }
                ?>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>