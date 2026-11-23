<div class="halaman-judul">
    <h2>Verifikasi Pembayaran</h2>
    <span class="jumlah"><?= count($daftar) ?> data</span>
</div>

<form method="get" action="index.php" class="inline filter-bar">
    <input type="hidden" name="c" value="bendahara">
    <input type="hidden" name="a" value="pembayaran">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Cari nama peserta">
    <select name="status">
        <option value="">Semua status</option>
        <?php foreach ($opsi as $o): ?>
            <option value="<?= e($o) ?>" <?= $o === $status ? 'selected' : '' ?>><?= e($o) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Cari</button>
    <?php if ($q !== '' || $status !== ''): ?>
        <a class="reset" href="index.php?c=bendahara&a=pembayaran">Reset</a>
    <?php endif; ?>
</form>

<table class="tabel">
    <tr><th>Peserta</th><th>Tanggal</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Ubah</th></tr>
    <?php foreach ($daftar as $b): ?>
    <tr>
        <td><strong><?= e($b['nama_lengkap']) ?></strong></td>
        <td><?= e($b['tanggal_bayar']) ?></td>
        <td>Rp <?= number_format((float)$b['jumlah'], 0, ',', '.') ?></td>
        <td><?= e($b['metode_pembayaran']) ?></td>
        <td><a class="btn btn-garis btn-kecil" href="public/uploads/bukti/<?= e($b['bukti_pembayaran']) ?>" target="_blank">Lihat</a></td>
        <td><?= badge($b['status_pembayaran']) ?></td>
        <td>
            <form method="post" action="index.php?c=bendahara&a=ubah" class="inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$b['id_pembayaran'] ?>">
                <select name="status">
                    <?php foreach ($opsi as $o): ?>
                        <option <?= $o === $b['status_pembayaran'] ? 'selected' : '' ?>><?= e($o) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">OK</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?>
        <tr><td colspan="7" class="kosong-baris"><?= ($q !== '' || $status !== '') ? 'Tidak ada data yang cocok.' : 'Belum ada pembayaran.' ?></td></tr>
    <?php endif; ?>
</table>