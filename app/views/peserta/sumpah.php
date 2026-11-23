<h2>Pengajuan Sumpah Advokat</h2>

<?php if (!$pengajuan): ?>
    <div class="kartu">
        <p>Anda belum mengajukan sumpah.</p>
        <form method="post" action="index.php?c=pengajuansumpah&a=ajukan">
            <?= csrf_field() ?>
            <button type="submit">Ajukan sumpah</button>
        </form>
    </div>
<?php else: ?>
    <div class="kartu">
        <p>Tanggal pengajuan: <?= e($pengajuan['tanggal_pengajuan']) ?></p>
        <p>Status pemberkasan: <strong><?= badge($pengajuan['status_pemberkasan']) ?></strong></p>
        <?php if (!empty($pengajuan['catatan'])): ?><p>Catatan: <?= e($pengajuan['catatan']) ?></p><?php endif; ?>
    </div>

    <?php if ($jadwal): ?>
    <div class="kartu">
        <h3>Jadwal sumpah</h3>
        <p><?= e($jadwal['tanggal_sumpah']) ?>, pukul <?= e($jadwal['waktu_sumpah']) ?></p>
        <p>Tempat: <?= e($jadwal['tempat_sumpah']) ?></p>
        <?php if (!empty($jadwal['keterangan'])): ?><p><?= e($jadwal['keterangan']) ?></p><?php endif; ?>
    </div>
    <?php endif; ?>

    <h3>Berkas sumpah</h3>
    <div class="kartu">
        <form method="post" action="index.php?c=pengajuansumpah&a=upload" enctype="multipart/form-data" class="form-biodata">
            <?= csrf_field() ?>
            <label>Jenis berkas</label>
            <select name="jenis"><?php foreach ($jenis as $j): ?><option><?= e($j) ?></option><?php endforeach; ?></select>
            <label>File (PDF/JPG/PNG, maks. 5 MB)</label>
            <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
            <button type="submit">Unggah</button>
        </form>
    </div>

    <table class="tabel">
        <tr><th>Jenis</th><th>File</th><th>Status</th></tr>
        <?php foreach ($dokumen as $x): ?>
        <tr>
            <td><?= e($x['jenis_dokumen']) ?></td>
            <td><a href="public/<?= e($x['file_path']) ?>" target="_blank"><?= e($x['nama_file']) ?></a></td>
            <td><?= e($statusCol ? ($x[$statusCol] ?? '-') : '-') ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$dokumen): ?><tr><td colspan="3">Belum ada berkas.</td></tr><?php endif; ?>
    </table>
<?php endif; ?>