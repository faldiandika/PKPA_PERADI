<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA PERADI - Peserta</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../../../public/css/style.css') ?>"></head>
<body>
<nav class="menu">
    <a href="index.php" class="brand"><img class="logo" src="public/img/" alt="PERADI" onerror="this.style.display='none'"></a>    <a href="index.php?c=peserta&a=biodata">Biodata</a>
    <a href="index.php?c=pendaftaran&a=index">Pendaftaran</a>
    <a href="index.php?c=dokumen&a=index">Dokumen</a>
    <a href="index.php?c=pembayaran&a=index">Pembayaran</a>
    <a href="index.php?c=pengajuansumpah&a=index">Sumpah</a>
    <a class="keluar" href="index.php?c=auth&a=logout">Logout</a>
</nav>
<main class="konten">
<?php if ($f = flash()): ?>
    <div class="flash <?= e($f['tipe']) ?>"><?= e($f['pesan']) ?></div>
<?php endif; ?>