
<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class PengaturanController extends Controller {

    public function index(): void {
        $u = userLogin();

        if (!$u) {
            flash('Silakan login terlebih dahulu.', 'err');
            redirect('index.php?c=auth&a=login');
        }

        $role = $u['role'];
        $daftarRole = ['admin', 'peserta', 'bendahara', 'ketua'];

        if (!in_array($role, $daftarRole, true)) {
            http_response_code(403);
            exit('Akses ditolak.');
        }

        $user = User::findById((int)$u['id_user']);

        if (!$user || $user['status'] !== 'aktif') {
            flash('Akun tidak ditemukan atau tidak aktif.', 'err');
            redirect('index.php?c=auth&a=logout');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_valid()) {
                flash('Sesi tidak valid, silakan coba lagi.', 'err');
                redirect('index.php?c=pengaturan&a=index');
            }

            $aksi = $_POST['aksi'] ?? '';

            if ($aksi === 'profil') {
                $nama = trim($_POST['nama'] ?? '');
                $email = trim($_POST['email'] ?? '');

                if ($nama === '' || strlen($nama) > 100) {
                    flash('Nama wajib diisi dan maksimal 100 karakter.', 'err');
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
                    flash('Format email tidak valid.', 'err');
                } elseif (User::emailDipakai($email, (int)$u['id_user'])) {
                    flash('Email sudah digunakan akun lain.', 'err');
                } else {
                    User::updateProfil((int)$u['id_user'], $nama, $email);
                    $_SESSION['nama'] = $nama;
                    flash('Profil berhasil diperbarui.');
                }

            } elseif ($aksi === 'password') {
                $lama = $_POST['password_lama'] ?? '';
                $baru = $_POST['password_baru'] ?? '';
                $konfirmasi = $_POST['konfirmasi'] ?? '';

                if (!password_verify($lama, $user['password'])) {
                    flash('Kata sandi lama tidak sesuai.', 'err');
                } elseif (strlen($baru) < 6) {
                    flash('Kata sandi baru minimal 6 karakter.', 'err');
                } elseif ($baru !== $konfirmasi) {
                    flash('Konfirmasi kata sandi tidak sama.', 'err');
                } else {
                    User::updatePassword((int)$u['id_user'], $baru);
                    flash('Kata sandi berhasil diperbarui.');
                }

            } else {
                flash('Permintaan tidak dikenali.', 'err');
            }

            redirect(urlDashboard($role));
        }

        unset($user['password']);

        $this->render(
            'pengaturan/index',
            ['user' => $user],
            $role . '/layout'
        );
    }
}
