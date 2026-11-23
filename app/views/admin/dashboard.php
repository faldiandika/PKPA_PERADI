<h2>Dashboard Admin</h2>
<p>Selamat datang, <?= e($user['nama'] ?? '') ?>.</p>

<div class="kartu">
    <h3>Pendaftaran PKPA</h3>
    <?php foreach ($pendaftaran as $r): ?><p><?= e($r['s']) ?>: <strong><?= (int)$r['n'] ?></strong></p><?php endforeach; ?>
    <?php if (!$pendaftaran): ?><p>Belum ada pendaftaran.</p><?php endif; ?>
    <p><a href="index.php?c=adminpendaftaran&a=index">Verifikasi pendaftaran</a></p>
</div>

<div class="kartu">
    <h3>Pengajuan sumpah</h3>
    <?php foreach ($sumpah as $r): ?><p><?= e($r['s']) ?>: <strong><?= (int)$r['n'] ?></strong></p><?php endforeach; ?>
    <?php if (!$sumpah): ?><p>Belum ada pengajuan.</p><?php endif; ?>
    <p><a href="index.php?c=adminsumpah&a=index">Periksa berkas sumpah</a></p>
</div>