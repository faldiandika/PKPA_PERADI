<h2>Pembayaran</h2>
<p>Biaya pendaftaran: <strong>Rp <?= number_format($jumlah, 0, ',', '.') ?></strong></p>

<div class="kartu">
    <h3>Rekening tujuan</h3>
    <p><?= e($rekening) ?></p>
</div>

<?php if ($bisaKirim): ?>
<div class="kartu">
    <form method="post" action="index.php?c=pembayaran&a=upload" enctype="multipart/form-data" class="form-biodata">
        <?= csrf_field() ?>
        <label>Metode pembayaran</label>
        <select name="metode">
            <?php foreach ($metode as $m): ?><option><?= e($m) ?></option><?php endforeach; ?>
        </select>
        <label>Bukti bayar (JPG/PNG/PDF, maks. 3 MB)</label>
        <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
        <button type="submit">Kirim bukti</button>
    </form>
</div>
<?php else: ?>
<div class="kartu"><p>Bukti pembayaran Anda sudah dikirim. Status dapat dilihat pada tabel di bawah.</p></div>
<?php endif; ?>

<table class="tabel">
    <tr><th>Tanggal</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Catatan</th></tr>
    <?php foreach ($pembayaran as $b): ?>
    <tr>
        <td><?= e($b['tanggal_bayar']) ?></td>
        <td>Rp <?= number_format((float)$b['jumlah'], 0, ',', '.') ?></td>
        <td><?= e($b['metode_pembayaran']) ?></td>
        <td><a href="public/uploads/bukti/<?= e($b['bukti_pembayaran']) ?>" target="_blank">Lihat</a></td>
        <td><?= badge($b['status_pembayaran']) ?></td>
        <td><?= e($b['catatan'] ?? '') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$pembayaran): ?><tr><td colspan="6">Belum ada pembayaran.</td></tr><?php endif; ?>
</table>