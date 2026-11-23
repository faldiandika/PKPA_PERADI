<h2>Pengajuan Sumpah</h2>
<table class="tabel">
    <tr><th>Nama</th><th>Tanggal pengajuan</th><th>Status</th><th></th></tr>
    <?php foreach ($daftar as $r): ?>
    <tr>
        <td><?= e($r['nama_lengkap']) ?></td>
        <td><?= e($r['tanggal_pengajuan']) ?></td>
        <td><?= badge($r['status_pemberkasan']) ?></td>
        <td><a href="index.php?c=adminsumpah&a=detail&id=<?= (int)$r['id_pengajuan_sumpah'] ?>">Periksa</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="4">Belum ada pengajuan.</td></tr><?php endif; ?>
</table>