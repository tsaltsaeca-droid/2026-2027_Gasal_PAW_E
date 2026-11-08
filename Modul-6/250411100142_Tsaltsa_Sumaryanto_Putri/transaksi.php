<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan,
        (SELECT COUNT(*) FROM transaksi_detail d WHERE d.transaksi_id = t.id) AS jml_item
    FROM transaksi t JOIN pelanggan p ON p.id = t.pelanggan_id ORDER BY t.id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Data Transaksi</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9"><h3 style="color:#337ab7">Data Transaksi (Master)</h3></div>
    <div class="col-sm-3 text-right"><a href="barang.php" class="btn btn-primary btn-sm">Data Barang</a></div>
  </div>
  <hr>
  <table class="table table-bordered table-hover">
    <thead>
      <tr class="info"><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Jml Item</th><th>Total</th><th>Tindakan</th></tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= (int)$row['id'] ?></td>
        <td><?= e($row['waktu_transaksi']) ?></td>
        <td><?= e($row['pelanggan']) ?></td>
        <td><?= e($row['keterangan']) ?></td>
        <td><?= (int)$row['jml_item'] ?></td>
        <td><?= rupiah($row['total']) ?></td>
        <td><a href="transaksi_detail.php?id=<?= (int)$row['id'] ?>" class="btn btn-success btn-xs">Detail</a></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
