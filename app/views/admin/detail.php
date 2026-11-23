<h2>Detail Pendaftaran</h2>
<p><a href="index.php?c=adminpendaftaran&a=index">&laquo; Kembali</a></p>

<div class="kartu">
    <h3>Biodata</h3>
    <p>Nama: <?= e($pd['nama_lengkap']) ?></p>
    <p>NIK: <?= e($pd['nik']) ?></p>
    <p>Tempat/tgl lahir: <?= e($pd['tempat_lahir']) ?>, <?= e($pd['tanggal_lahir']) ?></p>
    <p>Alamat: <?= e($pd['alamat']) ?></p>
    <p>Telepon: <?= e($pd['no_telepon']) ?> | Email: <?= e($pd['email']) ?></p>
    <p>Perguruan tinggi: <?= e($pd['perguruan_tinggi']) ?> (ijazah <?= e($pd['nomor_ijazah']) ?>)</p>
    <?php if (!empty($pd['pas_foto'])): ?>
        <img class="pas-foto" src="public/uploads/pas_foto/<?= e($pd['pas_foto']) ?>" alt="Pas foto" width="100">
    <?php endif; ?>
</div>

<div class="kartu">
    <h3>Status pendaftaran: <?= badge($pd['status_pendaftaran']) ?></h3>
    <form method="post" action="index.php?c=adminpendaftaran&a=status" class="form-biodata">
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

<h3>Dokumen</h3>
<table class="tabel">
    <tr><th>Jenis</th><th>File</th><th>Status</th><th>Catatan</th><th>Ubah</th></tr>
    <?php foreach ($dokumen as $x): $st = $statusCol ? ($x[$statusCol] ?? '') : ''; ?>
    <tr>
        <td><?= e($x['jenis_dokumen']) ?></td>
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
    <?php if (!$dokumen): ?><tr><td colspan="5">Belum ada dokumen.</td></tr><?php endif; ?>
</table>