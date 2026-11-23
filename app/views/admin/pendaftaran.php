<h2>Verifikasi Pendaftaran</h2>
<table class="tabel">
    <tr><th>Nama</th><th>NIK</th><th>Periode</th><th>Tanggal</th><th>Status</th><th></th></tr>
    <?php foreach ($daftar as $r): ?>
    <tr>
        <td><?= e($r['nama_lengkap']) ?></td>
        <td><?= e($r['nik']) ?></td>
        <td><?= e($r['periode']) ?></td>
        <td><?= e($r['tanggal_daftar']) ?></td>
        <td><?= badge($r['status_pendaftaran']) ?></td>
        <td><a href="index.php?c=adminpendaftaran&a=detail&id=<?= (int)$r['id_pendaftaran'] ?>">Periksa</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="6">Belum ada pendaftaran.</td></tr><?php endif; ?>
</table>