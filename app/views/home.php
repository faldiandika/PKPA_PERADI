<?php
$cfg = require __DIR__ . '/../../config/rekening.php';

// Kontak DPC. GANTI setelah dapat data resmi dari narasumber.
$kontak = [
    'alamat'  => '........',
    'telepon' => '........',
    'email'   => '........',
    'jam'     => '........',
];
$h = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
$biaya = 'Rp ' . number_format((int)$cfg['biaya'], 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA DPC PERADI FBI Kota Palu</title>
<link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../public/css/style.css') ?>"></head>
<body class="beranda">

<nav class="topbar">
    <a class="topbar-brand" href="index.php">
        <img src="public/img/logo-peradi.png" alt="PERADI" onerror="this.style.display='none'">
        <span>PKPA Online</span>
    </a>
    <div class="topbar-aksi">
        <a class="btn btn-garis btn-kecil" href="index.php?c=auth&a=login">Masuk</a>
        <a class="btn btn-kecil" href="index.php?c=auth&a=registrasi">Daftar</a>
    </div>
</nav>

<header class="hero hero-baru">
    <div class="hero-isi">
        <span class="hero-label">DPC PERADI FBI Kota Palu</span>
        <h1>Pendaftaran PKPA Online</h1>
        <p>Pendidikan Khusus Profesi Advokat. Daftar, unggah berkas, dan pantau status verifikasi dari satu akun.</p>
        <div class="aksi">
            <a class="btn" href="index.php?c=auth&a=registrasi">Daftar Akun</a>
            <a class="btn btn-garis" href="index.php?c=auth&a=login">Masuk</a>
        </div>
        <div class="hero-stat">
            <div><strong>4</strong><span>dokumen persyaratan</span></div>
            <div><strong><?= $h($biaya) ?></strong><span>biaya pendaftaran</span></div>
            <div><strong>100%</strong><span>proses online</span></div>
        </div>
    </div>
</header>

<section class="blok reveal">
    <div class="isi">
        <h2>Alur Pendaftaran</h2>
        <p class="tengah">Pendaftaran dilakukan pada periode yang sedang dibuka oleh DPC.</p>
        <div class="timeline">
            <div class="tl-item"><span class="no">1</span><h3>Buat akun</h3><p>Registrasi dan lengkapi biodata beserta pas foto.</p></div>
            <div class="tl-item"><span class="no">2</span><h3>Daftar PKPA</h3><p>Ajukan pendaftaran pada periode yang dibuka.</p></div>
            <div class="tl-item"><span class="no">3</span><h3>Unggah berkas</h3><p>Kirim dokumen persyaratan dan bukti pembayaran.</p></div>
            <div class="tl-item"><span class="no">4</span><h3>Pantau status</h3><p>Lihat hasil verifikasi dan catatan perbaikan dari akun Anda.</p></div>
        </div>
    </div>
</section>

<section class="blok blok-muda reveal">
    <div class="isi">
        <h2>Persyaratan Dokumen</h2>
        <p class="tengah">Siapkan dalam bentuk file PDF, JPG, atau PNG, maksimal 5 MB per file.</p>
        <div class="kartu ceklis-kartu">
            <ul class="ceklis">
                <li><strong>Ijazah Sarjana Hukum</strong><span>Dari perguruan tinggi.</span></li>
                <li><strong>KTP</strong><span>Yang masih berlaku.</span></li>
                <li><strong>Kartu Keluarga</strong><span>Versi terbaru.</span></li>
                <li><strong>Transkrip Nilai</strong><span>Dari kampus.</span></li>
            </ul>
            <p class="catatan">Pas foto tidak perlu diunggah di sini, cukup saat mengisi biodata.</p>
        </div>
    </div>
</section>

<section class="blok reveal">
    <div class="isi">
        <h2>Biaya dan Pembayaran</h2>
        <div class="kartu harga-kartu">
            <div class="harga-kiri">
                <span class="harga-label">Biaya pendaftaran</span>
                <span class="harga-angka"><?= $h($biaya) ?></span>
                <span class="harga-ket">Transfer Bank</span>
            </div>
            <div class="harga-kanan">
                <h3>Rekening tujuan</h3>
                <p><?= $h($cfg['bank']) ?><br>No. Rek <strong><?= $h($cfg['nomor']) ?></strong><br>a.n. <?= $h($cfg['atas_nama']) ?></p>
                <p class="catatan">Unggah bukti bayar (JPG, PNG, atau PDF, maks. 3 MB) dari akun Anda.</p>
            </div>
        </div>
    </div>
</section>

<section class="blok blok-muda reveal">
    <div class="isi">
        <h2>Status yang Dapat Dipantau</h2>
        <p class="tengah">Setiap tahap diverifikasi pengurus, dan hasilnya langsung terlihat di akun Anda.</p>
        <div class="arti-status">
            <div><span class="badge menunggu">menunggu</span><p>Berkas sedang menunggu diperiksa.</p></div>
            <div><span class="badge diverifikasi">diverifikasi</span><p>Sudah diperiksa dan sesuai.</p></div>
            <div><span class="badge diterima">diterima</span><p>Pendaftaran disetujui.</p></div>
            <div><span class="badge revisi">revisi</span><p>Perlu diperbaiki, lihat catatan.</p></div>
            <div><span class="badge ditolak">ditolak</span><p>Belum memenuhi persyaratan.</p></div>
        </div>
    </div>
</section>

<section class="blok reveal">
    <div class="isi">
        <h2>Kontak DPC</h2>
        <div class="grid">
            <div class="kartu"><h3>Alamat</h3><p><?= $h($kontak['alamat']) ?></p></div>
            <div class="kartu"><h3>Telepon</h3><p><?= $h($kontak['telepon']) ?></p></div>
            <div class="kartu"><h3>Email</h3><p><?= $h($kontak['email']) ?></p></div>
            <div class="kartu"><h3>Jam layanan</h3><p><?= $h($kontak['jam']) ?></p></div>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Siap mendaftar?</h2>
    <p>Buat akun dan mulai proses pendaftaran PKPA Anda.</p>
    <a class="btn" href="index.php?c=auth&a=registrasi">Daftar Akun</a>
</section>

<footer class="kaki">&copy; <?= date('Y') ?> DPC PERADI FBI Kota Palu</footer>

<script>
document.body.classList.add('js');
(function () {
    var els = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) { els.forEach(function (e) { e.classList.add('tampil'); }); return; }
    var io = new IntersectionObserver(function (list) {
        list.forEach(function (x) { if (x.isIntersecting) { x.target.classList.add('tampil'); io.unobserve(x.target); } });
    }, { threshold: 0.12 });
    els.forEach(function (e) { io.observe(e); });
})();
</script>
</body>
</html>