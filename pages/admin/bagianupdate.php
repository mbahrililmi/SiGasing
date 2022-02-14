<?php

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

if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM bagian WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();

    if (isset($row['id'])) {
        if (isset($_POST['button_update'])) {
            $database = new Database();
            $db = $database->getConnection();

            $validateSql = "SELECT * FROM bagian WHERE nama_bagian = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1, $_POST['nama_bagian']);
            $stmt->bindParam(2, $_POST['id']);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismis="alert" aria-hidden="true"></button>
                    <h5><i class="icon fas fa-check"></i>Gagal</h5>
                    Nama Bagian sudah ada
                </div>
        <?php
            } else {
                $id = htmlspecialchars($_POST['id']);

                $nama_bagian = htmlspecialchars($_POST['nama_bagian']);
                $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
                $nama_lokasi = htmlspecialchars($_POST['nama_lokasi']);

                $updateSql = "UPDATE bagian SET nama_bagian = ?, karyawan_id = ?, lokasi_id = ? WHERE id = ?";
                $stmt = $db->prepare($updateSql);
                $stmt->bindParam(1, $nama_bagian);
                $stmt->bindParam(2, $nama_lengkap);
                $stmt->bindParam(3, $nama_lokasi);
                $stmt->bindParam(4, $_POST['id']);
                if ($stmt->execute()) {
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "berhasil ubah data";
                } else {
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Gagal ubah data";
                }
                echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
            }
        }
        ?>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb2">
                    <div class="col-sm-6">
                        <h1>Ubah Data Bagian</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=bagianread">Jabatan</a></li>
                            <li class="breadcrumb-item">Ubah Data</li>
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
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <div class="form-group">
                            <label for="nama_bagian">Nama Bagian</label>
                            <input type="text" class="form-control" name="nama_bagian" id="nama_bagian" value="<?= $row['nama_bagian']; ?>">
                        </div>
                        <div>
                            <label for="nama_lengkap">Nama Kepala Bagian</label>
                            <select name="nama_lengkap" class="form-select form-control text-dark" aria-label="Default select example">
                                <?php while ($karyawan = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <option <?= ($row['karyawan_id'] == $karyawan['id']) ? 'selected' : '' ?> value="<?= $karyawan['id'] ?>"><?= $karyawan['nama_lengkap'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="nama_lokasi">Nama Lokasi Bagian</label>
                            <select name="nama_lokasi" class="form-select form-control text-dark" aria-label="Default select example">
                                <?php while ($lokasi = $stmt_lokasi->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <option <?= ($row['lokasi_id'] == $lokasi['id']) ? 'selected' : '' ?> value="<?= $lokasi['id'] ?>"><?= $lokasi['nama_lokasi'] ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="mt-3">
                            <a href="?page=bagianread" class="btn btn-danger btn-sm float-right ml-3">
                                <i class="fa fa-times"></i>
                                Batal
                            </a>
                            <button type="submit" name="button_update" class="btn btn-success btn-sm float-right">
                                <i class="fa fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <?php include_once "partials/scripts.php" ?>

<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
}
?>