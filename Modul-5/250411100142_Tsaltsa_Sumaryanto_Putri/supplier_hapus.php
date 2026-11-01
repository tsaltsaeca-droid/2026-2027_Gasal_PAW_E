<?php
include 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    $pesan = 'Data supplier berhasil dihapus.';
} elseif (mysqli_errno($conn) == 1451) {
    // supplier masih dipakai oleh tabel barang (foreign key)
    $pesan = 'Supplier tidak dapat dihapus karena masih dipakai oleh data barang.';
} else {
    $pesan = 'Gagal menghapus data.';
}
header('Location: supplier.php?pesan=' . urlencode($pesan));
exit;
