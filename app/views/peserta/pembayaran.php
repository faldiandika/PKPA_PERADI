<div class="halaman-judul">
    <h2>Pembayaran</h2>
    <span class="jumlah"><?= count($pembayaran) ?> pembayaran</span>
</div>

<div class="info-bayar">
    <div class="ib ib-biaya">
        <span>Biaya pendaftaran</span>
        <strong>Rp <?= number_format($jumlah, 0, ',', '.') ?></strong>
    </div>
    <div class="ib">
        <span>Rekening tujuan</span>
        <p><?= e($rekening) ?></p>
    </div>
</div>

<?php if ($bisaKirim): ?>
<form method="post" action="index.php?c=pembayaran&a=upload" enctype="multipart/form-data" class="form-kartu">
    <?= csrf_field() ?>
    <h3 class="form-bagian">Kirim bukti pembayaran</h3>
    <div class="form-grid">
        <div class="field">
            <label>Metode pembayaran</label>
            <select name="metode">
                <?php foreach ($metode as $m): ?><option><?= e($m) ?></option><?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label>Bukti bayar (JPG/PNG/PDF, maks. 3 MB)</label>
            <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>
    </div>
    <div class="form-aksi">
        <button type="submit">Kirim bukti</button>
    </div>
</form>
<?php else: ?>
<div class="info-selesai">Bukti pembayaran Anda sudah dikirim. Status dapat dilihat pada tabel di bawah.</div>
<?php endif; ?>

<h3 class="sub-judul">Riwayat pembayaran</h3>
<table class="tabel">
    <tr><th>Tanggal</th><th>Jumlah</th><th>Metode</th><th>Bukti</th><th>Status</th><th>Catatan</th></tr>
    <?php foreach ($pembayaran as $b): ?>
    <tr>
        <td><?= e($b['tanggal_bayar']) ?></td>
        <td>Rp <?= number_format((float)$b['jumlah'], 0, ',', '.') ?></td>
        <td><?= e($b['metode_pembayaran']) ?></td>
        <td><a class="btn btn-garis btn-kecil" href="public/uploads/bukti/<?= e($b['bukti_pembayaran']) ?>" target="_blank">Lihat</a></td>
        <td><?= badge($b['status_pembayaran']) ?></td>
        <td><?= e($b['catatan'] ?? '') ?: '-' ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$pembayaran): ?><tr><td colspan="6" class="kosong-baris">Belum ada pembayaran.</td></tr><?php endif; ?>
</table>