<?php
function e($s): string {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void {
    header("Location: $url");
    exit;
}

function flash(?string $pesan = null, string $tipe = 'ok') {
    if ($pesan !== null) {
        $_SESSION['flash'] = ['pesan' => $pesan, 'tipe' => $tipe];
        return null;
    }
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function csrf_token(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string {
    return '<input type="hidden" name="csrf" value="' . csrf_token() . '">';
}

function csrf_valid(): bool {
    return isset($_POST['csrf'], $_SESSION['csrf'])
        && hash_equals($_SESSION['csrf'], $_POST['csrf']);
}

function userLogin(): ?array {
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return [
        'id_user' => $_SESSION['user_id'],
        'nama'    => $_SESSION['nama'] ?? '',
        'role'    => $_SESSION['role'] ?? '',
    ];
}

function urlDashboard(string $role): string {
    $peta = [
        'peserta'   => 'index.php?c=peserta&a=dashboard',
        'admin'     => 'index.php?c=admin&a=dashboard',
        'bendahara' => 'index.php?c=bendahara&a=dashboard',
        'ketua'     => 'index.php?c=ketua&a=dashboard',
    ];
    return $peta[$role] ?? 'index.php?c=auth&a=login';
}

function wajibRole(string $role): void {
    $u = userLogin();
    if (!$u) {
        flash('Silakan login terlebih dahulu.', 'err');
        redirect('index.php?c=auth&a=login');
    }
    if ($u['role'] !== $role) {
        flash('Anda tidak berhak membuka halaman itu.', 'err');
        redirect(urlDashboard($u['role']));
    }

    function badge(?string $s): string {
        $s = (string)$s;
        return $s === '' ? '-' : '<span class="badge ' . e($s) . '">' . e($s) . '</span>';
    }
}