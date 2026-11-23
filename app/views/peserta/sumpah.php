
<?php
// Ambil status dokumen terbaru untuk setiap jenis
$statusDokumen = [];

foreach ($dokumen ?? [] as $x) {
    $namaJenis = $x['jenis_dokumen'];
    $status = $statusCol ? ($x[$statusCol] ?? '-') : '-';

    if (!isset($statusDokumen[$namaJenis])) {
        $statusDokumen[$namaJenis] = $status;
    }
}

// Jenis yang masih boleh diunggah:
// belum pernah diunggah atau berstatus revisi
$jenisUpload = [];

foreach ($jenis as $j) {
    $status = $statusDokumen[$j] ?? null;

    if ($status === null || $status === 'revisi') {
        $jenisUpload[] = $j;
    }
}
?>

<div class="halaman-judul">
    <h2>Pengajuan Sumpah Advokat</h2>
</div>

<?php if (!$pengajuan): ?>
    <div class="kartu ajakan">
        <h3>Belum mengajukan</h3>
        <p>Anda belum mengajukan sumpah. Klik tombol di bawah setelah tahapan pendaftaran PKPA Anda selesai.</p>

        <form method="post" action="index.php?c=pengajuansumpah&a=ajukan">
            <?= csrf_field() ?>
            <button type="submit">Ajukan sumpah</button>
        </form>
    </div>

<?php else: ?>

    <div class="kartu">
        <h3>Status pengajuan</h3>

        <div class="biodata-grid">
            <div>
                <span>Tanggal pengajuan</span>
                <strong><?= e($pengajuan['tanggal_pengajuan']) ?></strong>
            </div>

            <div>
                <span>Status pemberkasan</span>
                <?= badge($pengajuan['status_pemberkasan']) ?>
            </div>
        </div>

        <?php if (!empty($pengajuan['catatan'])): ?>
            <div class="catatan-admin">
                <span>Catatan dari petugas</span>
                <p><?= e($pengajuan['catatan']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($jadwal): ?>
        <div class="jadwal-sumpah">
            <span class="jadwal-label">Jadwal sumpah</span>

            <strong class="jadwal-tgl">
                <?= e($jadwal['tanggal_sumpah']) ?>,
                pukul <?= e($jadwal['waktu_sumpah']) ?>
            </strong>

            <p>Tempat: <?= e($jadwal['tempat_sumpah']) ?></p>

            <?php if (!empty($jadwal['keterangan'])): ?>
                <p class="jadwal-ket">
                    <?= e($jadwal['keterangan']) ?>
                </p>
            <?php endif; ?>

        </div>
    <?php endif; ?>

    <?php if (!empty($jenisUpload)): ?>
        <form method="post"
              action="index.php?c=pengajuansumpah&a=upload"
              enctype="multipart/form-data"
              class="form-kartu">

            <?= csrf_field() ?>

            <h3 class="form-bagian">Unggah berkas sumpah</h3>

            <div class="form-grid">
                <div class="field">
                    <label>Jenis berkas</label>

                    <select name="jenis" required>
                        <?php foreach ($jenisUpload as $j): ?>
                            <option value="<?= e($j) ?>">
                                <?= e($j) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label>File (PDF/JPG/PNG, maks. 5 MB)</label>
                    <input type="file"
                           name="file"
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>
                </div>
            </div>

            <div class="form-aksi">
                <button type="submit">Unggah</button>
            </div>
        </form>

    <?php else: ?>
        <div class="kartu">
            <h3>Seluruh berkas sumpah sudah lengkap</h3>
            <p>Tidak ada berkas yang perlu diunggah atau diperbaiki saat ini.</p>
        </div>
    <?php endif; ?>

    <h3 class="sub-judul">Berkas yang sudah diunggah</h3>

    <table class="tabel">
        <tr>
            <th>Jenis</th>
            <th>File</th>
            <th>Status</th>
        </tr>

        <?php foreach ($dokumen as $x): ?>
            <tr>
                <td>
                    <strong><?= e($x['jenis_dokumen']) ?></strong>
                </td>

                <td>
                    <a href="public/<?= e($x['file_path']) ?>" target="_blank">
                        <?= e($x['nama_file']) ?>
                    </a>
                </td>

                <td>
                    <?= badge(
                        $statusCol
                            ? ($x[$statusCol] ?? '-')
                            : '-'
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>

        <?php if (!$dokumen): ?>
            <tr>
                <td colspan="3" class="kosong-baris">
                    Belum ada berkas.
                </td>
            </tr>
        <?php endif; ?>
    </table>

<?php endif; ?>
