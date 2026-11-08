<?php
include 'koneksi.php';
$id = (int)($_GET['id'] ?? $_POST['transaksi_id'] ?? 0);

function ambil_master($conn, $id) {
    $s = mysqli_prepare($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t
        JOIN pelanggan p ON p.id = t.pelanggan_id WHERE t.id=?");
    mysqli_stmt_bind_param($s, 'i', $id);
    mysqli_stmt_execute($s);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($s));
}
if (!ambil_master($conn, $id)) { header('Location: transaksi.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barang_id = (int)($_POST['barang_id'] ?? 0);
    $qty       = (int)($_POST['qty'] ?? 0);
    $pesan = ''; $tipe = 'danger';

    $s = mysqli_prepare($conn, "SELECT harga FROM barang WHERE id=?");
    mysqli_stmt_bind_param($s, 'i', $barang_id);
    mysqli_stmt_execute($s);
    $b = mysqli_fetch_assoc(mysqli_stmt_get_result($s));

    $s = mysqli_prepare($conn, "SELECT 1 FROM transaksi_detail WHERE transaksi_id=? AND barang_id=?");
    mysqli_stmt_bind_param($s, 'ii', $id, $barang_id);
    mysqli_stmt_execute($s);
    $sudah = mysqli_fetch_assoc(mysqli_stmt_get_result($s));

    if (!$b)            $pesan = 'Barang tidak valid.';
    elseif ($qty < 1)   $pesan = 'Qty harus minimal 1.';
    elseif ($sudah)     $pesan = 'Barang tersebut sudah ada pada transaksi ini.';
    else {
        mysqli_begin_transaction($conn);
        $s = mysqli_prepare($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($s, 'iiii', $id, $barang_id, $b['harga'], $qty);
        $ok1 = mysqli_stmt_execute($s);

        $s = mysqli_prepare($conn, "UPDATE transaksi SET total =
            (SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id=?)
            WHERE id=?");
        mysqli_stmt_bind_param($s, 'ii', $id, $id);
        $ok2 = mysqli_stmt_execute($s);

        if ($ok1 && $ok2) { mysqli_commit($conn); $pesan = 'Detail transaksi disimpan, total diperbarui.'; $tipe = 'success'; }
        else              { mysqli_rollback($conn); $pesan = 'Gagal menyimpan detail.'; }
    }
    header('Location: transaksi_detail.php?id=' . $id . '&tipe=' . $tipe . '&pesan=' . urlencode($pesan));
    exit;
}

$m = ambil_master($conn, $id);

$s = mysqli_prepare($conn, "SELECT d.*, b.kode_barang, b.nama_barang FROM transaksi_detail d
    JOIN barang b ON b.id = d.barang_id WHERE d.transaksi_id=? ORDER BY b.nama_barang");
mysqli_stmt_bind_param($s, 'i', $id);
mysqli_stmt_execute($s);
$detail = mysqli_stmt_get_result($s);

$s = mysqli_prepare($conn, "SELECT id, kode_barang, nama_barang, harga FROM barang
    WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id=?) ORDER BY nama_barang");
mysqli_stmt_bind_param($s, 'i', $id);
mysqli_stmt_execute($s);
$pilihan = mysqli_stmt_get_result($s);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Master Detail Transaksi</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:30px">
  <h3 style="color:#337ab7">Master Detail Transaksi</h3>
  <hr>
  <?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-<?= e($_GET['tipe'] ?? 'info') ?>"><?= e($_GET['pesan']) ?></div>
  <?php endif; ?>

  <div class="panel panel-primary">
    <div class="panel-heading">Master: Transaksi #<?= (int)$m['id'] ?></div>
    <table class="table table-bordered" style="margin:0">
      <tr><th width="20%">Tanggal</th><td><?= e($m['waktu_transaksi']) ?></td></tr>
      <tr><th>Pelanggan</th><td><?= e($m['pelanggan_id']) ?> - <?= e($m['pelanggan']) ?></td></tr>
      <tr><th>Keterangan</th><td><?= e($m['keterangan']) ?></td></tr>
      <tr><th>Total</th><td><strong><?= rupiah($m['total']) ?></strong></td></tr>
    </table>
  </div>

  <div class="panel panel-info">
    <div class="panel-heading">Detail: Barang pada transaksi ini</div>
    <table class="table table-bordered table-hover" style="margin:0">
      <thead><tr><th>No</th><th>Kode</th><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
      <tbody>
      <?php $no = 1; while ($d = mysqli_fetch_assoc($detail)): ?>
        <tr>
          <td><?= $no++ ?></td><td><?= e($d['kode_barang']) ?></td><td><?= e($d['nama_barang']) ?></td>
          <td><?= rupiah($d['harga']) ?></td><td><?= (int)$d['qty'] ?></td>
          <td><?= rupiah($d['harga'] * $d['qty']) ?></td>
        </tr>
      <?php endwhile; ?>
      <?php if ($no === 1): ?><tr><td colspan="6" class="text-center text-muted">Belum ada detail.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>

  <form method="post" class="form-inline">
    <input type="hidden" name="transaksi_id" value="<?= (int)$m['id'] ?>">
    <select name="barang_id" class="form-control" required>
      <option value="">-- Pilih Barang --</option>
      <?php while ($p = mysqli_fetch_assoc($pilihan)): ?>
        <option value="<?= (int)$p['id'] ?>"><?= e($p['kode_barang']) ?> - <?= e($p['nama_barang']) ?> (<?= rupiah($p['harga']) ?>)</option>
      <?php endwhile; ?>
    </select>
    <input type="number" name="qty" class="form-control" min="1" value="1" required style="width:90px">
    <button type="submit" class="btn btn-success">Tambah Detail</button>
    <a href="transaksi.php" class="btn btn-default">Kembali</a>
  </form>
</div>
</body>
</html>
