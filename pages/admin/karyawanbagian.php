<?php

$database = new Database();
$db = $database->getConnection();

$selectSql = "SELECT * FROM bagian";
$stmt_bagian = $db->prepare($selectSql);
$stmt_bagian->execute();

if (isset($_GET['id'])) {

    $database = new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1, $_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])) {
?>

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb2">
                    <div class="col-sm-6">
                        <h1>Karyawan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                            <li class="breadcrumb-item">Riwayat Bagian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Bagian</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nik">Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" name="nik" id="nik" disabled value="<?= $row['nik'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="handphone">Handphone</label>
                                <input type="text" class="form-control" name="handphone" id="handphone" disabled value="<?= $row['handphone'] ?>">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" disabled value="<?= $row['nama_lengkap'] ?>">
                            </div>
                        </div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="karyawan_id" value="<?= $id; ?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bagian_id">Bagian</label>
                                    <select name="bagian_id" class="form-control">
                                        <?php while ($bagian = $stmt_bagian->fetch(PDO::FETCH_ASSOC)) : ?>
                                            <option <?= ($row['id'] == $bagian['karyawan_id']) ? 'selected' : ''; ?> value="<?= $bagian['id'] ?>"><?= $bagian['nama_bagian'] ?></option>
                                        <?php endwhile ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" name="button_update" class="btn btn-success btn-block float-right mb-3">
                                        <i class="fa fa-save"></i>
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}
