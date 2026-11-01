<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Data Master Supplier</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9"><h3 style="color:#337ab7">Data Master Supplier</h3></div>
    <div class="col-sm-3 text-right">
      <a href="supplier_tambah.php" class="btn btn-success btn-sm">Tambah Data</a>
    </div>
  </div>
  <hr>
  <?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-info"><?= e($_GET['pesan']) ?></div>
  <?php endif; ?>
  <table class="table table-bordered table-hover">
    <thead>
      <tr class="info"><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>
    </thead>
    <tbody>
    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= e($row['nama']) ?></td>
        <td><?= e($row['telp']) ?></td>
        <td><?= e($row['alamat']) ?></td>
        <td>
          <a href="supplier_edit.php?id=<?= (int)$row['id'] ?>" class="btn btn-warning btn-xs">Edit</a>
          <a href="supplier_hapus.php?id=<?= (int)$row['id'] ?>" class="btn btn-danger btn-xs"
             onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
