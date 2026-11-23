<h2>Dashboard Peserta</h2>
<p>Selamat datang, <?= e($user['nama'] ?? '') ?>.</p>

<?php if (!empty($peserta['pas_foto'])): ?>
    <img class="pas-foto" src="public/uploads/pas_foto/<?= e($peserta['pas_foto']) ?>" alt="Pas foto" width="120">
<?php endif; ?>

<div class="kartu">
    <h3>Langkah pendaftaran</h3>
    <ol>
        <li>
            Biodata:
            <?php if ($peserta): ?>
                <strong>sudah diisi</strong>
                (<a href="index.php?c=peserta&a=biodata">ubah</a>)
            <?php else: ?>
                <strong>belum diisi</strong>
                (<a href="index.php?c=peserta&a=biodata">isi sekarang</a>)
            <?php endif; ?>
        </li>
        <li>Pendaftaran PKPA</li>
        <li>Upload dokumen</li>
        <li>Upload bukti pembayaran</li>
        <li>Pengajuan sumpah</li>
    </ol>
</div>
<h3>Pemberitahuan</h3>
<?php foreach ($notif as [$tipe, $pesan]): ?>
    <div class="flash <?= e($tipe) ?>"><?= e($pesan) ?></div>
<?php endforeach; ?>