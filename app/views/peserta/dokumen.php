<h2>Dokumen Persyaratan</h2>

<div class="kartu">
    <form method="post" action="index.php?c=dokumen&a=upload" enctype="multipart/form-data" class="form-biodata">
        <?= csrf_field() ?>
        <label>Jenis dokumen</label>
        <select name="jenis">
            <?php foreach ($jenis as $j): ?><option><?= e($j) ?></option><?php endforeach; ?>
        </select>
        <label>File (PDF/JPG/PNG, maks. 5 MB)</label>
        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
        <button type="submit">Unggah</button>
    </form>
</div>

<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Tanggal</th><th>Status</th></tr>
    <?php foreach ($dokumen as $x): ?>
    <tr>
        <td><?= e($x['jenis_dokumen']) ?></td>
        <td><a href="public/<?= e($x['file_path']) ?>" target="_blank"><?= e($x['nama_file']) ?></a></td>
        <td><?= e($x['tanggal_upload']) ?></td>
        <td><?= badge($statusCol ? ($x[$statusCol] ?? '-') : '-') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$dokumen): ?><tr><td colspan="4">Belum ada dokumen.</td></tr><?php endif; ?>
</table>