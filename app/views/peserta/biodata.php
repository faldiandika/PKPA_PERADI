<div class="halaman-judul">
    <h2>Biodata Peserta</h2>
</div>

<?php if ($error !== ''): ?>
    <div class="flash err"><?= e($error) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form-kartu">
    <?= csrf_field() ?>

    <h3 class="form-bagian">Data diri</h3>
    <div class="form-grid">
        <div class="field">
            <label>Nama lengkap</label>
            <input type="text" name="nama_lengkap" value="<?= e($isi['nama_lengkap']) ?>" required>
        </div>
        <div class="field">
            <label>NIK (16 digit)</label>
            <input type="text" name="nik" maxlength="16" inputmode="numeric" value="<?= e($isi['nik']) ?>" required>
        </div>
        <div class="field">
            <label>Tempat lahir</label>
            <input type="text" name="tempat_lahir" value="<?= e($isi['tempat_lahir']) ?>" required>
        </div>
        <div class="field">
            <label>Tanggal lahir</label>
            <input type="date" name="tanggal_lahir" value="<?= e($isi['tanggal_lahir']) ?>" required>
        </div>
        <div class="field">
            <label>No. telepon</label>
            <input type="text" name="no_telepon" inputmode="tel" value="<?= e($isi['no_telepon']) ?>" required>
        </div>
        <div class="field penuh">
            <label>Alamat</label>
            <textarea name="alamat" rows="3" required><?= e($isi['alamat']) ?></textarea>
        </div>
    </div>

    <h3 class="form-bagian">Pendidikan</h3>
    <div class="form-grid">
        <div class="field">
            <label>Perguruan tinggi</label>
            <input type="text" name="perguruan_tinggi" value="<?= e($isi['perguruan_tinggi']) ?>" required>
        </div>
        <div class="field">
            <label>Nomor ijazah</label>
            <input type="text" name="nomor_ijazah" value="<?= e($isi['nomor_ijazah']) ?>" required>
        </div>
    </div>

    <h3 class="form-bagian">Pas foto</h3>
    <div class="foto-baris">
        <?php if (!empty($peserta['pas_foto'])): ?>
            <img class="pas-foto" src="public/uploads/pas_foto/<?= e($peserta['pas_foto']) ?>" alt="Pas foto" width="110">
        <?php endif; ?>
        <div class="field">
            <label>Unggah pas foto (JPG/PNG, maks. 2 MB)</label>
            <input type="file" name="pas_foto" accept=".jpg,.jpeg,.png">
            <?php if (!empty($peserta['pas_foto'])): ?>
                <small>Biarkan kosong kalau tidak ingin mengganti foto.</small>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-aksi">
        <button type="submit">Simpan biodata</button>
    </div>
</form>