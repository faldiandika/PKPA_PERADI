<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PKPA Peradi</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-page">
<form class="login-box" method="post" action="index.php?c=auth&a=login">
    <h1>Login</h1>
    <?php if ($error): ?><p class="alert err"><?= e($error) ?></p><?php endif; ?>
    <?= csrf_field() ?>
    <label>Email</label>
    <input type="email" name="email" required autofocus>
    <label>Password</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Masuk</button>
</form>
</body>
</html>