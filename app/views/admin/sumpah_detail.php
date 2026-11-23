
<div class="halaman-judul">
    <h2>Pemeriksaan Berkas Sumpah</h2>
    <a class="btn btn-garis btn-kecil" href="index.php?c=adminsumpah&a=index">&laquo; Kembali</a>
</div>

<div class="kartu">
    <div class="info-peserta">
        <div><span>Peserta</span><strong><?= e($s['nama_lengkap']) ?></strong></div>
        <div><span>NIK</span><strong><?= e($s['nik']) ?></strong></div>
        <div><span>Status pemberkasan</span><?= badge($s['status_pemberkasan']) ?></div>
    </div>
    <form method="post" action="index.php?c=adminsumpah&a=status" class="form-biodata form-lebar">
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

<h3 class="sub-judul">Berkas</h3>
<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Status</th><th>Ubah</th></tr>
    <?php foreach ($dokumen as $x): $st = $statusCol ? ($x[$statusCol] ?? '') : ''; ?>
    <tr>
        <td><strong><?= e($x['jenis_dokumen']) ?></strong></td>
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
    <?php if (!$dokumen): ?>
        <tr><td colspan="4" class="kosong-baris">Belum ada berkas.</td></tr>
    <?php endif; ?>
</table>

<h3 class="sub-judul">Jadwal sumpah</h3>
<div class="kartu">
    <form method="post" action="index.php?c=adminsumpah&a=jadwal" class="form-biodata form-lebar">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$s['id_pengajuan_sumpah'] ?>">

        <label>Tanggal (DD-MM-YYYY)</label>
        <input type="text" name="tanggal"
            value="<?= !empty($jadwal['tanggal_sumpah']) ? date('d-m-Y', strtotime($jadwal['tanggal_sumpah'])) : '' ?>"
            placeholder="Contoh: 24-11-2026"
            pattern="\d{2}-\d{2}-\d{4}"
            title="Gunakan format tanggal DD-MM-YYYY"
            required>

        <label>Waktu</label>
        <input type="time" name="waktu" value="<?= e(isset($jadwal['waktu_sumpah']) ? substr($jadwal['waktu_sumpah'], 0, 5) : '') ?>" required>

        <label>Tempat</label>
        <input type="text" name="tempat" value="<?= e($jadwal['tempat_sumpah'] ?? '') ?>" required>

        <label>Keterangan</label>
        <textarea name="keterangan" rows="2"><?= e($jadwal['keterangan'] ?? '') ?></textarea>

        <button type="submit">Simpan jadwal</button>
    </form>
</div>
