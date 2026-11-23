<h2>Verifikasi Pendaftaran</h2>

<form method="get" action="index.php" class="inline" style="margin-bottom:12px">
    <input type="hidden" name="c" value="adminpendaftaran">
    <input type="hidden" name="a" value="index">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari nama, NIK, atau periode" style="min-width:240px">
    <select name="status">
        <option value="">Semua status</option>
        <?php foreach ($opsi as $o): ?>
            <option value="<?= e($o) ?>" <?= $o === $status ? 'selected' : '' ?>><?= e($o) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Cari</button>
    <?php if ($q !== '' || $status !== ''): ?>
        <a href="index.php?c=adminpendaftaran&a=index">Reset</a>
    <?php endif; ?>
</form>

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
    <?php if (!$daftar): ?>
        <tr><td colspan="6"><?= ($q !== '' || $status !== '') ? 'Tidak ada data yang cocok.' : 'Belum ada pendaftaran.' ?></td></tr>
    <?php endif; ?>
</table>