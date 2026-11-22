<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA PERADI - Bendahara</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<nav class="menu">
    <strong>PKPA PERADI</strong>
    <a href="index.php?c=bendahara&a=dashboard">Dashboard</a>
    <a href="index.php?c=bendahara&a=pembayaran">Pembayaran</a>
    <a class="keluar" href="index.php?c=auth&a=logout">Logout</a>
</nav>
<main class="konten">
<?php if ($f = flash()): ?>
    <div class="flash <?= e($f['tipe']) ?>"><?= e($f['pesan']) ?></div>
<?php endif; ?>