<?php
$aksiAktif = $_GET['a'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA PERADI - Ketua</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../../public/css/style.css') ?>"></head>
<body>
<nav class="menu">
    <a href="index.php" class="brand">
        <img class="logo" src="public/img/logo-peradi.png" alt="PERADI" onerror="this.style.display='none'">
        <span class="brand-teks">PKPA Online <small>Ketua</small></span>
    </a>
    <a href="index.php?c=ketua&a=dashboard" class="<?= $aksiAktif === 'dashboard' ? 'aktif' : '' ?>">Beranda</a>
    <a href="index.php?c=ketua&a=peserta" class="<?= $aksiAktif === 'peserta' ? 'aktif' : '' ?>">Daftar Peserta</a>
    <a class="keluar" href="index.php?c=auth&a=logout">Logout</a>
</nav>
<main class="konten">
<?php if ($f = flash()): ?>
    <div class="flash <?= e($f['tipe']) ?>"><?= e($f['pesan']) ?></div>
<?php endif; ?>