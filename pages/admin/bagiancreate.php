<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    $validateSQL = "SELECT * FROM bagian WHERE nama_bagian = ?";
    $stmt = $db->prepare($validateSQL);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<div class='alert alert-warning' role='alert'>Nama Bagian Sudah Tersedia </div>";
    } else {

        $nama_bagian = htmlspecialchars($_POST['nama_bagian']);
        $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
        $nama_lokasi = htmlspecialchars($_POST['nama_lokasi']);

        $insertSQL = "INSERT INTO bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ?";
        $stmt = $db->prepare($insertSQL);
        $stmt->bindParam(1, $nama_bagian);
        $stmt->bindParam(2, $nama_lengkap);
        $stmt->bindParam(3, $nama_lokasi);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Simpan Berhasil";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Simpan Gagal";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
} else {
    // melakukan koneksi database
    $database = new Database();
    $db = $database->getConnection();

    // mengambil data karyawan
    $selectSqlKaryawan = "SELECT * FROM karyawan";
    $stmt_karyawan = $db->prepare($selectSqlKaryawan);
    $stmt_karyawan->execute();

    // mengambil data lokasi
    $selectSqlLokasi = "SELECT * FROM lokasi";
    $stmt_lokasi = $db->prepare($selectSqlLokasi);
    $stmt_lokasi->execute();
}

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                    <li class="breadcrumb-item">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah Jabatan</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nama_bagian">Nama Bagian</label>
                    <input type="text" class="form-control" name="nama_bagian" id="nama_bagian">
                </div>
                <div>
                    <label for="nama_lengkap">Nama Kepala Bagian</label>
                    <select name="nama_lengkap" class="form-select form-control text-dark" aria-label="Default select example">
                        <?php while ($kepalabagian = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $kepalabagian['id'] ?>"><?= $kepalabagian['nama_lengkap'] ?></option>
                        <?php endwhile; ?>
                        ?>
                    </select>
                </div>
                <div class="mt-3">
                    <label for="nama_lokasi">Nama Lokasi Bagian</label>
                    <select name="nama_lokasi" class="form-select form-control text-dark" aria-label="Default select example">
                        <?php while ($lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) : ?>
                            <option value="<?= $lokasi['id'] ?>"><?= $lokasi['nama_lokasi'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mt-3">
                    <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right ml-3">
                        <i class="fa fa-times"></i>
                        Batal
                    </a>
                    <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                        <i class="fa fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include_once "partials/scripts.php" ?>