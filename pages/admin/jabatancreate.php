<?php
if (isset($_POST['button_create'])) {

    $database = new Database();
    $db = $database->getConnection();

    $validateSQL = "SELECT * FROM jabatan WHERE nama_jabatan = ?";
    $stmt = $db->prepare($validateSQL);
    $stmt->bindParam(1, $_POST['nama_jabatan']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "<div class='alert alert-warning' role='alert'>Nama Lokasi Sudah Tersedia </div>";
    } else {

        $nama_jabatan = htmlspecialchars($_POST['nama_jabatan']);
        $gapok_jabatan = htmlspecialchars($_POST['gapok_jabatan']);
        $tunjangan_jabatan = htmlspecialchars($_POST['tunjangan_jabatan']);
        $uang_makan_perhari = htmlspecialchars($_POST['uang_makan_perhari']);

        $insertSQL = "INSERT INTO jabatan SET nama_jabatan = ?, gapok_jabatan = ?, tunjangan_jabatan = ?, uang_makan_perhari = ?";
        $stmt = $db->prepare($insertSQL);
        $stmt->bindParam(1, $nama_jabatan);
        $stmt->bindParam(2, $gapok_jabatan);
        $stmt->bindParam(3, $tunjangan_jabatan);
        $stmt->bindParam(4, $uang_makan_perhari);
        if ($stmt->execute()) {
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Simpan Berhasil";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Simpan Gagal";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
}

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data Lokasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
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
                    <label for="nama_jabatan">Nama Jabatan</label>
                    <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan">
                </div>
                <div class="form-group">
                    <label for="gapok_jabatan">Gapok</label>
                    <input type="number" class="form-control" name="gapok_jabatan" id="gapok_jabatan" onkeypress="return (event.charCode > 47 && event.charCode < 58 || event.charCode == 46)">
                </div>
                <div class="form-group">
                    <label for="tunjangan_jabatan">Tunjangan</label>
                    <input type="number" class="form-control" name="tunjangan_jabatan" id="tunjangan_jabatan" onkeypress="return (event.charCode > 47 && event.charCode < 58 || event.charCode == 46)">
                </div>
                <div class="form-group">
                    <label for="uang_makan_perhari">Uang Makan Perhari</label>
                    <input type="number" class="form-control" name="uang_makan_perhari" id="uang_makan_perhari" onkeypress="return (event.charCode > 47 && event.charCode < 58 || event.charCode == 46)">
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