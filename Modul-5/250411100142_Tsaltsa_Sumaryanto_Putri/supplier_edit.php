<?php
include 'koneksi.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'sssi', $nama, $telp, $alamat, $id);
    $ok = mysqli_stmt_execute($stmt);
    header('Location: supplier.php?pesan=' . urlencode($ok ? 'Data supplier berhasil diperbarui.' : 'Gagal memperbarui data.'));
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM supplier WHERE id=?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) {
    header('Location: supplier.php?pesan=' . urlencode('Data tidak ditemukan.'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Edit Data Master Supplier</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <h2 style="color:#337ab7">Edit Data Master Supplier</h2>
  <hr>
  <form method="post" class="form-horizontal">
    <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
    <div class="form-group">
      <label class="col-sm-4 control-label">Nama</label>
      <div class="col-sm-5"><input type="text" name="nama" class="form-control" value="<?= e($data['nama']) ?>" maxlength="100" required></div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Telp</label>
      <div class="col-sm-3"><input type="text" name="telp" class="form-control" value="<?= e($data['telp']) ?>" maxlength="12" required></div>
    </div>
    <div class="form-group">
      <label class="col-sm-4 control-label">Alamat</label>
      <div class="col-sm-3"><input type="text" name="alamat" class="form-control" value="<?= e($data['alamat']) ?>" required></div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-4 col-sm-5">
        <button type="submit" class="btn btn-success btn-sm">Update</button>
        <a href="supplier.php" class="btn btn-danger btn-sm">Batal</a>
      </div>
    </div>
  </form>
</div>
</body>
</html>
