<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT b.*, s.nama AS supplier
    FROM barang b JOIN supplier s ON s.id = b.supplier_id ORDER BY b.id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Data Master Barang</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9"><h3 style="color:#337ab7">Data Master Barang</h3></div>
    <div class="col-sm-3 text-right">
      <a href="transaksi.php" class="btn btn-primary btn-sm">Transaksi</a>
    </div>
  </div>
  <hr>
  <?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-<?= e($_GET['tipe'] ?? 'info') ?>"><?= e($_GET['pesan']) ?></div>
  <?php endif; ?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr class="info"><th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Tindakan</th></tr>
    </thead>
    <tbody>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= e($row['kode_barang']) ?></td>
        <td><?= e($row['nama_barang']) ?></td>
        <td><?= rupiah($row['harga']) ?></td>
        <td><?= (int)$row['stok'] ?></td>
        <td><?= e($row['supplier']) ?></td>
        <td>
          <a href="barang_hapus.php?id=<?= (int)$row['id'] ?>" class="btn btn-danger btn-xs"
             onclick="return confirm('Anda yakin akan menghapus barang ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
