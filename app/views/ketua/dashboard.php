<h2>Dashboard Ketua</h2>
<p>Selamat datang, <?= e($user['nama'] ?? '') ?>.</p>

<div class="kartu">
    <p>Total peserta: <strong><?= (int)$jmlPeserta ?></strong></p>
    <p>Jadwal sumpah terjadwal: <strong><?= (int)$jmlJadwal ?></strong></p>
</div>

<?php
$blok = ['Status pendaftaran' => $pendaftaran, 'Status pembayaran' => $pembayaran, 'Status pemberkasan sumpah' => $sumpah];
foreach ($blok as $judul => $baris): ?>
<div class="kartu">
    <h3><?= e($judul) ?></h3>
    <?php foreach ($baris as $r): ?><p><?= e($r['s']) ?>: <strong><?= (int)$r['n'] ?></strong></p><?php endforeach; ?>
    <?php if (!$baris): ?><p>Belum ada data.</p><?php endif; ?>
</div>
<?php endforeach; ?>