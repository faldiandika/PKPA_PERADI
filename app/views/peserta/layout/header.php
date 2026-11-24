
<?php
$ctrlAktif = $_GET['c'] ?? '';
$aksiAktif = $_GET['a'] ?? '';

$menuAktif = function (string $c, ?string $a = null) use ($ctrlAktif, $aksiAktif) {
    if ($ctrlAktif !== $c) return '';
    return ($a === null || $aksiAktif === $a) ? 'aktif' : '';
};

$dashAktif = ($ctrlAktif === 'peserta' && $aksiAktif !== 'biodata') ? 'aktif' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA PERADI - Peserta</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../../public/css/style.css') ?>">
</head>
<body>
<nav class="menu">
    <a href="index.php" class="brand">
        <img class="logo" src="public/img/logo-peradi.png" alt="PERADI" onerror="this.style.display='none'">
        <span class="brand-teks">PKPA Online <small>Peserta</small></span>
    </a>
    <a href="index.php?c=peserta&a=dashboard" class="<?= $dashAktif ?>">Beranda</a>
    <a href="index.php?c=peserta&a=biodata" class="<?= $menuAktif('peserta', 'biodata') ?>">Biodata</a>
    <a href="index.php?c=pendaftaran&a=index" class="<?= $menuAktif('pendaftaran') ?>">Daftar PKPA</a>
    <a href="index.php?c=dokumen&a=index" class="<?= $menuAktif('dokumen') ?>">Dokumen</a>
    <a href="index.php?c=pembayaran&a=index" class="<?= $menuAktif('pembayaran') ?>">Pembayaran</a>
    <a href="index.php?c=pengajuansumpah&a=index" class="<?= $menuAktif('pengajuansumpah') ?>">Pengajuan Sumpah</a>
    <a href="index.php?c=pengaturan&a=index"
    class="<?= $menuAktif('pengaturan') ?>">
    Pengaturan
    </a>
    <form action="index.php?c=auth&a=logout" method="POST" style="display:inline;">
        <?= csrf_field() ?>
        <button type="submit" class="keluar">Logout</button>
    </form>
</nav>
<main class="konten">
<?php if ($f = flash()): ?>
    <div class="flash <?= e($f['tipe']) ?>"><?= e($f['pesan']) ?></div>
<?php endif; ?>
