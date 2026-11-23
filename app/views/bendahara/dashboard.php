<h2>Dashboard Bendahara</h2>
<p>Selamat datang, <?= e($user['nama'] ?? '') ?>.</p>
<div class="kartu">
    <h3>Rekap pembayaran</h3>
    <?php foreach ($rekap as $r): ?>
        <p><?= e($r['s']) ?>: <strong><?= (int)$r['n'] ?></strong></p>
    <?php endforeach; ?>
    <?php if (!$rekap): ?><p>Belum ada pembayaran.</p><?php endif; ?>
    <p><a href="index.php?c=bendahara&a=pembayaran">Verifikasi pembayaran</a></p>
</div>