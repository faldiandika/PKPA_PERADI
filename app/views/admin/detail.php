<div class="halaman-judul">
    <h2>Detail Pendaftaran</h2>
    <a class="btn btn-garis btn-kecil" href="index.php?c=adminpendaftaran&a=index">&laquo; Kembali</a>
</div>

<div class="kartu">
    <h3>Biodata</h3>
    <div class="biodata-wrap">
        <div class="biodata-grid">
            <div><span>Nama lengkap</span><strong><?= e($pd['nama_lengkap']) ?></strong></div>
            <div><span>NIK</span><strong><?= e($pd['nik']) ?></strong></div>
            <div><span>Tempat, tanggal lahir</span><strong><?= e($pd['tempat_lahir']) ?>, <?= e($pd['tanggal_lahir']) ?></strong></div>
            <div><span>Telepon</span><strong><?= e($pd['no_telepon']) ?></strong></div>
            <div><span>Email</span><strong><?= e($pd['email']) ?></strong></div>
            <div><span>Perguruan tinggi</span><strong><?= e($pd['perguruan_tinggi']) ?></strong></div>
            <div><span>Nomor ijazah</span><strong><?= e($pd['nomor_ijazah']) ?></strong></div>
            <div class="penuh"><span>Alamat</span><strong><?= e($pd['alamat']) ?></strong></div>
        </div>
        <?php if (!empty($pd['pas_foto'])): ?>
            <img class="pas-foto" src="public/uploads/pas_foto/<?= e($pd['pas_foto']) ?>" alt="Pas foto" width="110">
        <?php endif; ?>
    </div>
</div>

<div class="kartu">
    <div class="info-peserta">
        <div><span>Status pendaftaran</span><?= badge($pd['status_pendaftaran']) ?></div>
    </div>
    <form method="post" action="index.php?c=adminpendaftaran&a=status" class="form-biodata form-lebar">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= (int)$pd['id_pendaftaran'] ?>">
        <label>Ubah status</label>
        <select name="status">
            <?php foreach ($opsiPendaftaran as $o): ?>
                <option <?= $o === $pd['status_pendaftaran'] ? 'selected' : '' ?>><?= e($o) ?></option>
            <?php endforeach; ?>
        </select>
        <label>Catatan</label>
        <textarea name="catatan" rows="2"><?= e($pd['catatan'] ?? '') ?></textarea>
        <button type="submit">Simpan</button>
    </form>
</div>

<h3 class="sub-judul">Dokumen</h3>
<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Status</th><th>Catatan</th><th>Ubah</th></tr>
    <?php foreach ($dokumen as $x): $st = $statusCol ? ($x[$statusCol] ?? '') : ''; ?>
    <tr>
        <td><strong><?= e($x['jenis_dokumen']) ?></strong></td>
        <td><a href="public/<?= e($x['file_path']) ?>" target="_blank"><?= e($x['nama_file']) ?></a></td>
        <td><?= badge($st) ?></td>
        <td><?= e($x['catatan'] ?? '') ?></td>
        <td>
            <?php if ($opsiDokumen): ?>
            <form method="post" action="index.php?c=adminpendaftaran&a=dokumen" class="inline">
                <?= csrf_field() ?>
                <input type="hidden" name="id_pendaftaran" value="<?= (int)$pd['id_pendaftaran'] ?>">
                <input type="hidden" name="id_dokumen" value="<?= (int)$x['id_dokumen'] ?>">
                <select name="status">
                    <?php foreach ($opsiDokumen as $o): ?>
                        <option <?= $o === $st ? 'selected' : '' ?>><?= e($o) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="catatan" value="<?= e($x['catatan'] ?? '') ?>" placeholder="Catatan">
                <button type="submit">OK</button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$dokumen): ?><tr><td colspan="5" class="kosong-baris">Belum ada dokumen.</td></tr><?php endif; ?>
</table>