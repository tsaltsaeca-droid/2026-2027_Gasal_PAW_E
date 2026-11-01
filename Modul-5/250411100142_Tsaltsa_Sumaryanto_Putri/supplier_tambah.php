<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $stmt = mysqli_prepare($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'sss', $nama, $telp, $alamat);
    $ok = mysqli_stmt_execute($stmt);
    header('Location: supplier.php?pesan=' . urlencode($ok ? 'Data supplier berhasil ditambahkan.' : 'Gagal menambah data.'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Tambah Data Master Supplier Baru</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <h2 style="color:#337ab7">Tambah Data Master Supplier Baru</h2>
  <hr>
  <form method="post" class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-4 control-label">Nama</label>
      <div class="col-sm-5"><input type="text" name="nama" class="form-control" placeholder="Nama" maxlength="100" required></div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Telp</label>
      <div class="col-sm-3"><input type="text" name="telp" class="form-control" placeholder="telp" maxlength="12" required></div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Alamat</label>
      <div class="col-sm-3"><input type="text" name="alamat" class="form-control" placeholder="alamat" required></div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-5">
        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
        <a href="supplier.php" class="btn btn-danger btn-sm">Batal</a>
      </div>
    </div>
  </form>
</div>
</body>
</html>
