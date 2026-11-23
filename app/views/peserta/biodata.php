<h2>Biodata Peserta</h2>

<?php if ($error !== ''): ?>
    <div class="flash err"><?= e($error) ?></div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" class="form-biodata">
    <?= csrf_field() ?>

    <label>Nama lengkap</label>
    <input type="text" name="nama_lengkap" value="<?= e($isi['nama_lengkap']) ?>" required>

    <label>NIK (16 digit)</label>
    <input type="text" name="nik" maxlength="16" value="<?= e($isi['nik']) ?>" required>

    <label>Tempat lahir</label>
    <input type="text" name="tempat_lahir" value="<?= e($isi['tempat_lahir']) ?>" required>

    <label>Tanggal lahir</label>
    <input type="date" name="tanggal_lahir" value="<?= e($isi['tanggal_lahir']) ?>" required>

    <label>Alamat</label>
    <textarea name="alamat" rows="3" required><?= e($isi['alamat']) ?></textarea>

    <label>No. telepon</label>
    <input type="text" name="no_telepon" value="<?= e($isi['no_telepon']) ?>" required>

    <label>Perguruan tinggi</label>
    <input type="text" name="perguruan_tinggi" value="<?= e($isi['perguruan_tinggi']) ?>" required>

    <label>Nomor ijazah</label>
    <input type="text" name="nomor_ijazah" value="<?= e($isi['nomor_ijazah']) ?>" required>

    <label>Pas foto (JPG/PNG, maks. 2 MB)</label>
    <?php if (!empty($peserta['pas_foto'])): ?>
        <img class="pas-foto" src="public/uploads/pas_foto/<?= e($peserta['pas_foto']) ?>" alt="Pas foto" width="120">
        <small>Kosongkan kolom di bawah kalau tidak ingin mengganti foto.</small>
    <?php endif; ?>
    <input type="file" name="pas_foto" accept=".jpg,.jpeg,.png">

    <button type="submit">Simpan biodata</button>
</form>