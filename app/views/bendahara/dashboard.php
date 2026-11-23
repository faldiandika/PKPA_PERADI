<?php
$totalBayar = 0; foreach ($rekap as $r) { $totalBayar += (int)$r['n']; }
?>
<div class="dash-sapa">
    <div>
        <span class="dash-label">Beranda Bendahara</span>
        <h2>Selamat datang, <?= e($user['nama'] ?? '') ?></h2>
        <p>Periksa bukti pembayaran dan pantau rekap status pembayaran peserta dari sini.</p>
    </div>
</div>

<div class="dash-grid">
    <div class="kartu stat">
        <h3>Rekap pembayaran</h3>
        <div class="stat-total"><strong><?= $totalBayar ?></strong><span>total pembayaran</span></div>
        <?php foreach ($rekap as $r): ?>
            <div class="stat-baris"><span class="badge <?= e($r['s']) ?>"><?= e($r['s']) ?></span><strong><?= (int)$r['n'] ?></strong></div>
        <?php endforeach; ?>
        <?php if (!$rekap): ?><p class="kosong">Belum ada pembayaran.</p><?php endif; ?>
        <a class="btn stat-btn" href="index.php?c=bendahara&a=pembayaran">Verifikasi pembayaran</a>
    </div>
</div>