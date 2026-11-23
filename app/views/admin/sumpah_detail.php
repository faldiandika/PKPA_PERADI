<h2>Pemeriksaan Berkas Sumpah</h2>
<p><a href="index.php?c=adminsumpah&a=index">&laquo; Kembali</a></p>

<div class="kartu">
    <p>Peserta: <strong><?= e($s['nama_lengkap']) ?></strong> (NIK <?= e($s['nik']) ?>)</p>
    <p>Status pemberkasan: <strong><?= badge($s['status_pemberkasan']) ?></strong></p>
    <form method="post" action="index.php?c=adminsumpah&a=status" class="form-biodata">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$s['id_pengajuan_sumpah'] ?>">
        <label>Ubah status</label>
        <select name="status">
            <?php foreach ($opsiPengajuan as $o): ?>
                <option <?= $o === $s['status_pemberkasan'] ? 'selected' : '' ?>><?= e($o) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Catatan</label>
        <textarea name="catatan" rows="2"><?= e($s['catatan'] ?? '') ?></textarea>
        <button type="submit">Simpan</button>
    </form>
</div>

<h3>Berkas</h3>
<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Status</th><th>Ubah</th></tr>
    <?php foreach ($dokumen as $x): $st = $statusCol ? ($x[$statusCol] ?? '') : ''; ?>
    <tr>
        <td><?= e($x['jenis_dokumen']) ?></td>
        <td><a href="public/<?= e($x['file_path']) ?>" target="_blank"><?= e($x['nama_file']) ?></a></td>
        <td><?= badge($st) ?></td>
        <td>
            <?php if ($opsiDokumen): ?>
            <form method="post" action="index.php?c=adminsumpah&a=dokumen" class="inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int)$s['id_pengajuan_sumpah'] ?>">
                <input type="hidden" name="id_dokumen_sumpah" value="<?= (int)$x['id_dokumen_sumpah'] ?>">
                <select name="status">
                    <?php foreach ($opsiDokumen as $o): ?>
                        <option <?= $o === $st ? 'selected' : '' ?>><?= e($o) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">OK</button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$dokumen): ?><tr><td colspan="4">Belum ada berkas.</td></tr><?php endif; ?>
</table>

<h3>Jadwal sumpah</h3>
<div class="kartu">
    <form method="post" action="index.php?c=adminsumpah&a=jadwal" class="form-biodata">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$s['id_pengajuan_sumpah'] ?>">
        <label>Tanggal</label>
        <input type="date" name="tanggal" value="<?= e($jadwal['tanggal_sumpah'] ?? '') ?>" required>
        <label>Waktu</label>
        <input type="time" name="waktu" value="<?= e(isset($jadwal['waktu_sumpah']) ? substr($jadwal['waktu_sumpah'], 0, 5) : '') ?>" required>
        <label>Tempat</label>
        <input type="text" name="tempat" value="<?= e($jadwal['tempat_sumpah'] ?? '') ?>" required>
        <label>Keterangan</label>
        <textarea name="keterangan" rows="2"><?= e($jadwal['keterangan'] ?? '') ?></textarea>
        <button type="submit">Simpan jadwal</button>
    </form>
</div>