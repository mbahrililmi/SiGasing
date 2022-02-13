<?php include_once "partials/cssdatatables.php" ?>

<div class="content-header">
    <div class="container-fluid">

        <?php
        if (isset($_SESSION['hasil'])) {
            if ($_SESSION['hasil']) {
        ?>

                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismis="alert" aria-hidden="true"></button>
                    <h5><i class="icon fas fa-check"></i>Berhasil</h5>
                    <?php echo $_SESSION['pesan'] ?>
                </div>

            <?php
            } else {
            ?>

                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismis="alert" aria-hidden="true"></button>
                    <h5><i class="icon fas fa-ban"></i>Gagal</h5>
                    <?php echo $_SESSION['pesan'] ?>
                </div>

        <?php
            }
            unset($_SESSION['hasil']);
            unset($_SESSION['pesan']);
        }
        ?>

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Karyawan</h3>
            <a href="?page=karyawancreate" class="btn btn-success btn-sm float-right">
                <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Bagian</th>
                        <th>Jabatan</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Bagian</th>
                        <th>Jabatan</th>
                        <th>Opsi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $database = new Database();
                    $db = $database->getConnection();
                    $selectSql = "SELECT karyawan.id, karyawan.nama_lengkap,
                                    (
                                     SELECT jabatan.nama_jabatan
                                     FROM jabatan_karyawan
                                     INNER JOIN jabatan ON jabatan.id = jabatan_karyawan.jabatan_id
                                     WHERE jabatan_karyawan.karyawan_id = karyawan.id
                                     ORDER BY jabatan_karyawan.tanggal_mulai DESC
                                     LIMIT 1   
                                    ) jabatan_terkini,
                                    (
                                     SELECT bagian.nama_bagian
                                     FROM bagian_karyawan
                                     INNER JOIN bagian ON bagian.id = bagian_karyawan.bagian_id
                                     WHERE bagian_karyawan.karyawan_id = karyawan.id
                                     ORDER BY bagian_karyawan.tanggal_mulai DESC
                                     LIMIT 1   
                                    ) bagian_terkini
                                  FROM karyawan";
                    $stmt = $db->prepare($selectSql);
                    $stmt->execute();
                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $row['nama_lengkap'] ?></td>
                            <td><?php echo $row['jabatan_terkini'] ?></td>
                            <td><?php echo $row['bagian_terkini'] ?></td>
                            <td>
                                <a href="?page=karyawanupdate&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-sm mr-1">
                                    <i class="fa fa-edit"></i> Ubah
                                </a>
                                <a href="?page=karyawandelete&id=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm" onClick="javascript: return confirm('Konfirmasi data akan dihapus?');">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "partials/scripts.php" ?>
<?php include_once "partials/scriptsdatatables.php" ?>
<script>
    $(function() {
        $('#mytable').DataTable()
    });
</script>