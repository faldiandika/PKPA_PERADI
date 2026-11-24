
<?php
$aksiAktif = $_GET['a'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA PERADI - Bendahara</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../../public/css/style.css') ?>">
</head>
<body>
<nav class="menu">
    <a href="index.php" class="brand">
        <img class="logo" src="public/img/logo-peradi.png" alt="PERADI" onerror="this.style.display='none'">
        <span class="brand-teks">PKPA Online <small>Bendahara</small></span>
    </a>
    <a href="index.php?c=bendahara&a=dashboard" class="<?= $aksiAktif === 'dashboard' ? 'aktif' : '' ?>">Beranda</a>
    <a href="index.php?c=bendahara&a=pembayaran" class="<?= $aksiAktif === 'pembayaran' ? 'aktif' : '' ?>">Pembayaran</a>
    <a href="index.php?c=pengaturan&a=index"
    class="<?= ($_GET['c'] ?? '') === 'pengaturan' ? 'aktif' : '' ?>">
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
