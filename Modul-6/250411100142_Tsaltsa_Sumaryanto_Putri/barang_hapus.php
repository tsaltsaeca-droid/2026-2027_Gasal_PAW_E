<?php
include 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);

function kembali($pesan, $tipe) {
    header('Location: barang.php?tipe=' . $tipe . '&pesan=' . urlencode($pesan));
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT nama_barang FROM barang WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$barang) kembali('Data barang tidak ditemukan.', 'warning');

$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$jml = (int)mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['jml'];

if ($jml > 0) {
    kembali('Barang "' . $barang['nama_barang'] . '" tidak dapat dihapus karena masih digunakan pada ' . $jml . ' transaksi.', 'danger');
}

$stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);
$ok = mysqli_stmt_execute($stmt);
kembali($ok ? 'Barang "' . $barang['nama_barang'] . '" berhasil dihapus.' : 'Gagal menghapus barang.', $ok ? 'success' : 'danger');
