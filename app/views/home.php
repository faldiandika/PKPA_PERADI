<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PKPA DPC PERADI Kota Palu</title>
<link rel="stylesheet" href="public/css/style.css?v=<?= filemtime(__DIR__ . '/../../public/css/style.css') ?>"></head>
<body class="beranda">

<header class="hero">
    <div class="logo-kartu"><img class="logo" src="public/img/" alt="PERADI" onerror="this.parentNode.style.display='none'"></div>
    <h1>Pendaftaran PKPA Online</h1>
    <p>Pendidikan Khusus Profesi Advokat<br>DPC PERADI Kota Palu</p>
    <div class="aksi">
        <a class="btn" href="index.php?c=auth&a=login">Masuk</a>
        <a class="btn btn-garis" href="index.php?c=auth&a=registrasi">Daftar Akun</a>
    </div>
</header>

<section class="blok">
    <div class="isi">
        <h2>Alur Pendaftaran</h2>
        <div class="grid">
            <div class="kartu"><span class="no">1</span><h3>Buat akun</h3><p>Registrasi dan lengkapi biodata beserta pas foto.</p></div>
            <div class="kartu"><span class="no">2</span><h3>Daftar PKPA</h3><p>Ajukan pendaftaran pada periode yang dibuka.</p></div>
            <div class="kartu"><span class="no">3</span><h3>Unggah berkas</h3><p>Kirim dokumen persyaratan dan bukti pembayaran.</p></div>
            <div class="kartu"><span class="no">4</span><h3>Pantau status</h3><p>Lihat hasil verifikasi dan catatan perbaikan dari akun Anda.</p></div>
        </div>
    </div>
</section>

<section class="blok blok-muda">
    <div class="isi">
        <h2>Kemudahan untuk Peserta</h2>
        <div class="grid">
            <div class="kartu fitur"><div class="ikon">📝</div><h3>Formulir digital</h3><p>Biodata dan pendaftaran diisi online, tanpa formulir kertas.</p></div>
            <div class="kartu fitur"><div class="ikon">📎</div><h3>Unggah sendiri</h3><p>Dokumen dan bukti pembayaran diunggah langsung dari akun Anda.</p></div>
            <div class="kartu fitur"><div class="ikon">🔔</div><h3>Pemberitahuan</h3><p>Catatan perbaikan dari admin dan bendahara tampil di dashboard.</p></div>
            <div class="kartu fitur"><div class="ikon">📱</div><h3>Bisa lewat HP</h3><p>Tampilan menyesuaikan layar, dapat dibuka dari browser HP.</p></div>
        </div>
    </div>
</section>

<section class="blok">
    <div class="isi">
        <h2>Status yang Dapat Dipantau</h2>
        <p class="tengah">Setiap tahap diverifikasi pengurus, dan hasilnya langsung terlihat di akun Anda.</p>
        <div class="status-baris">
            <span class="badge menunggu">menunggu</span>
            <span class="badge diverifikasi">diverifikasi</span>
            <span class="badge diterima">diterima</span>
            <span class="badge revisi">revisi</span>
            <span class="badge ditolak">ditolak</span>
        </div>
    </div>
</section>

<section class="blok blok-muda">
    <div class="isi">
        <h2>Dikelola Bersama</h2>
        <div class="grid">
            <div class="kartu"><h3>Admin</h3><p>Memverifikasi pendaftaran dan dokumen, serta memeriksa berkas sumpah.</p></div>
            <div class="kartu"><h3>Bendahara</h3><p>Memverifikasi pembayaran dan merekap status pembayaran.</p></div>
            <div class="kartu"><h3>Ketua</h3><p>Memantau rekap pendaftar per periode dan mencetak laporan.</p></div>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Siap mendaftar?</h2>
    <p>Buat akun dan mulai proses pendaftaran PKPA Anda.</p>
    <a class="btn" href="index.php?c=auth&a=registrasi">Daftar Akun</a>
</section>

<footer class="kaki">&copy; <?= date('Y') ?> DPC PERADI Kota Palu</footer>
</body>
</html>