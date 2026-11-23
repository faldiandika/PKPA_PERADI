<h2>Verifikasi Pembayaran</h2>
<table class="tabel">
    <tr><th>Peserta</th><th>Tanggal</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Ubah</th></tr>
    <?php foreach ($daftar as $b): ?>
    <tr>
        <td><?= e($b['nama_lengkap']) ?></td>
        <td><?= e($b['tanggal_bayar']) ?></td>
        <td>Rp <?= number_format((float)$b['jumlah'], 0, ',', '.') ?></td>
        <td><?= e($b['metode_pembayaran']) ?></td>
        <td><a href="public/uploads/bukti/<?= e($b['bukti_pembayaran']) ?>" target="_blank">Lihat</a></td>
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
    <?php if (!$daftar): ?><tr><td colspan="7">Belum ada pembayaran.</td></tr><?php endif; ?>
</table>