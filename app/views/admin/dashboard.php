<?php
$totalDaftar = 0; foreach ($pendaftaran as $r) { $totalDaftar += (int)$r['n']; }
$totalSumpah = 0; foreach ($sumpah as $r) { $totalSumpah += (int)$r['n']; }
?>
<div class="dash-sapa">
    <div>
        <span class="dash-label">Beranda Admin</span>
        <h2>Selamat datang, <?= e($user['nama'] ?? '') ?></h2>
        <p>Periksa pendaftaran, dokumen, dan berkas sumpah peserta dari sini.</p>
    </div>
</div>

<div class="dash-grid">
    <div class="kartu stat">
        <h3>Pendaftaran PKPA</h3>
        <div class="stat-total"><strong><?= $totalDaftar ?></strong><span>total pendaftaran</span></div>
        <?php foreach ($pendaftaran as $r): ?>
            <div class="stat-baris"><span class="badge <?= e($r['s']) ?>"><?= e($r['s']) ?></span><strong><?= (int)$r['n'] ?></strong></div>
        <?php endforeach; ?>
        <?php if (!$pendaftaran): ?><p class="kosong">Belum ada pendaftaran.</p><?php endif; ?>
        <a class="btn stat-btn" href="index.php?c=adminpendaftaran&a=index">Verifikasi pendaftaran</a>
    </div>

    <div class="kartu stat">
        <h3>Pengajuan sumpah</h3>
        <div class="stat-total"><strong><?= $totalSumpah ?></strong><span>total pengajuan</span></div>
        <?php foreach ($sumpah as $r): ?>
            <div class="stat-baris"><span class="badge <?= e($r['s']) ?>"><?= e($r['s']) ?></span><strong><?= (int)$r['n'] ?></strong></div>
        <?php endforeach; ?>
        <?php if (!$sumpah): ?><p class="kosong">Belum ada pengajuan.</p><?php endif; ?>
        <a class="btn stat-btn" href="index.php?c=adminsumpah&a=index">Periksa berkas sumpah</a>
    </div>
</div>

<div class="kartu backup-kartu">
    <div>
        <h3>Backup data</h3>
        <p>Unduh salinan seluruh data (struktur dan isi tabel) dalam file SQL. Simpan di tempat aman secara berkala.</p>
    </div>
    <a class="btn btn-garis" href="index.php?c=admin&a=backup">Unduh backup</a>
</div>