<div class="halaman-judul">
    <h2>Pengajuan Sumpah</h2>
    <span class="jumlah"><?= count($daftar) ?> data</span>
</div>

<table class="tabel">
    <tr><th>Nama</th><th>Tanggal pengajuan</th><th>Status</th><th></th></tr>
    <?php foreach ($daftar as $r): ?>
    <tr>
        <td><strong><?= e($r['nama_lengkap']) ?></strong></td>
        <td><?= e($r['tanggal_pengajuan']) ?></td>
        <td><?= badge($r['status_pemberkasan']) ?></td>
        <td><a class="btn btn-kecil" href="index.php?c=adminsumpah&a=detail&id=<?= (int)$r['id_pengajuan_sumpah'] ?>">Periksa</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="4" class="kosong-baris">Belum ada pengajuan.</td></tr><?php endif; ?>
</table>