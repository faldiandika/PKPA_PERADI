<div class="halaman-judul">
    <h2>Verifikasi Pendaftaran</h2>
    <span class="jumlah"><?= count($daftar) ?> data</span>
</div>

<form method="get" action="index.php" class="inline filter-bar">
    <input type="hidden" name="c" value="adminpendaftaran">
    <input type="hidden" name="a" value="index">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari nama, NIK, atau periode">
    <select name="status">
        <option value="">Semua status</option>
        <?php foreach ($opsi as $o): ?>
            <option value="<?= e($o) ?>" <?= $o === $status ? 'selected' : '' ?>><?= e($o) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Cari</button>
    <?php if ($q !== '' || $status !== ''): ?>
        <a class="reset" href="index.php?c=adminpendaftaran&a=index">Reset</a>
    <?php endif; ?>
</form>

<table class="tabel">
    <tr><th>Nama</th><th>NIK</th><th>Periode</th><th>Tanggal</th><th>Status</th><th></th></tr>
    <?php foreach ($daftar as $r): ?>
    <tr>
        <td><strong><?= e($r['nama_lengkap']) ?></strong></td>
        <td><?= e($r['nik']) ?></td>
        <td><?= e($r['periode']) ?></td>
        <td><?= e($r['tanggal_daftar']) ?></td>
        <td><?= badge($r['status_pendaftaran']) ?></td>
        <td><a class="btn btn-kecil" href="index.php?c=adminpendaftaran&a=detail&id=<?= (int)$r['id_pendaftaran'] ?>">Periksa</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?>
        <tr><td colspan="6" class="kosong-baris"><?= ($q !== '' || $status !== '') ? 'Tidak ada data yang cocok.' : 'Belum ada pendaftaran.' ?></td></tr>
    <?php endif; ?>
</table>