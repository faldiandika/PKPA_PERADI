
<div class="halaman-judul">
    <h2>Pengaturan Akun</h2>
</div>

<h3 class="form-bagian">Informasi Akun</h3>
<form method="post" class="form-kartu">
    <?= csrf_field() ?>
    <input type="hidden" name="aksi" value="profil">

    <div class="form-grid">
        <div class="field">
            <label>Nama lengkap</label>
            <input type="text" name="nama"
                   value="<?= e($user['nama']) ?>" maxlength="100" required>
        </div>

        <div class="field">
            <label>Email</label>
            <input type="email" name="email"
                   value="<?= e($user['email']) ?>" maxlength="100" required>
        </div>

        <div class="field">
            <label>Role akun</label>
            <input type="text" value="<?= e(ucfirst($user['role'])) ?>" disabled>
        </div>
    </div>

    <div class="form-aksi">
        <button type="submit">Simpan Profil</button>
    </div>
</form>

<h3 class="form-bagian">Ganti Kata Sandi</h3>
<form method="post" class="form-kartu">
    <?= csrf_field() ?>
    <input type="hidden" name="aksi" value="password">

    <div class="form-grid">
        <div class="field penuh">
            <label>Kata sandi lama</label>
            <input type="password" name="password_lama" required>
        </div>

        <div class="field">
            <label>Kata sandi baru</label>
            <input type="password" name="password_baru"
                   minlength="6" required>
        </div>

        <div class="field">
            <label>Konfirmasi kata sandi baru</label>
            <input type="password" name="konfirmasi"
                   minlength="6" required>
        </div>
    </div>

    <div class="form-aksi">
        <button type="submit">Ganti Kata Sandi</button>
    </div>
</form>
