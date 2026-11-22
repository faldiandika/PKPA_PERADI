<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - PKPA Peradi</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-page">
<form class="login-box" method="post" action="index.php?c=auth&a=registrasi">
    <h1>Registrasi Peserta</h1>
    <?php if ($error): ?><p class="alert err"><?= e($error) ?></p><?php endif; ?>
    <?= csrf_field() ?>
    <label>Nama</label>
    <input type="text" name="nama" value="<?= e($nama) ?>" required autofocus>
    <label>Email</label>
    <input type="email" name="email" value="<?= e($email) ?>" required>
    <label>Password</label>
    <input type="password" name="password" required>
    <label>Konfirmasi Password</label>
    <input type="password" name="konfirmasi" required>
    <button class="btn" type="submit">Daftar</button>
    <p class="tautan">Sudah punya akun? <a href="index.php?c=auth&a=login">Login</a></p>
</form>
</body>
</html>