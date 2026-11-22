<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {

    public function login(): void {
        if (!empty($_SESSION['user_id'])) {
            $this->keBeranda($_SESSION['role']);
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_valid()) {
                $error = 'Sesi tidak valid, coba lagi.';
            } else {
                $u = User::attempt(trim($_POST['email'] ?? ''), $_POST['password'] ?? '');
                if ($u) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $u['id_user'];
                    $_SESSION['nama']    = $u['nama'];
                    $_SESSION['role']    = $u['role'];
                    $this->keBeranda($u['role']);
                }
                $error = 'Email atau password salah, atau akun tidak aktif.';
            }
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
        redirect('index.php?c=auth&a=login');
    }

    private function keBeranda(string $role): void {
        // Sementara: dashboard tiap role belum dibuat
        exit('Login berhasil sebagai ' . e($role) . '. Dashboard menyusul. <a href="index.php?c=auth&a=logout">Logout</a>');
    }
}