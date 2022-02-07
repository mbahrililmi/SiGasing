<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $database = new Database();
    $connection = $database->getConnection();

    $deleteSQL = "DELETE FROM bagian WHERE id = ?";
    $statement = $connection->prepare($deleteSQL);
    $statement->bindParam(1, $id);
    if ($statement->execute()) {
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = 'Berhasil hapus data';
    } else {
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = 'Gagal hapus data';
    }
    echo '<meta http-equiv="refresh" content="0;url=?page=bagianread">';
}
