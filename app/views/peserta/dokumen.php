<div class="halaman-judul">
    <h2>Dokumen Persyaratan</h2>
    <span class="jumlah"><?= count($dokumen) ?> dokumen</span>
</div>

<form method="post" action="index.php?c=dokumen&a=upload" enctype="multipart/form-data" class="form-kartu">
    <?= csrf_field() ?>
    <h3 class="form-bagian">Unggah dokumen</h3>
    <div class="form-grid">
        <div class="field">
            <label>Jenis dokumen</label>
            <select name="jenis">
                <?php foreach ($jenis as $j): ?><option><?= e($j) ?></option><?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label>File (PDF/JPG/PNG, maks. 5 MB)</label>
            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
        </div>
    </div>
    <div class="form-aksi">
        <button type="submit">Unggah</button>
    </div>
</form>

<h3 class="sub-judul">Dokumen yang sudah diunggah</h3>
<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Tanggal</th><th>Status</th><th>Catatan</th></tr>
    <?php foreach ($dokumen as $x): ?>
    <tr>
        <td><strong><?= e($x['jenis_dokumen']) ?></strong></td>
        <td><a href="public/<?= e($x['file_path']) ?>" target="_blank"><?= e($x['nama_file']) ?></a></td>
        <td><?= e($x['tanggal_upload']) ?></td>
        <td><?= badge($statusCol ? ($x[$statusCol] ?? '-') : '-') ?></td>
        <td><?= e($x['catatan'] ?? '') ?: '-' ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$dokumen): ?><tr><td colspan="5" class="kosong-baris">Belum ada dokumen.</td></tr><?php endif; ?>
</table>