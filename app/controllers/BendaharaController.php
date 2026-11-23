<?php
require_once __DIR__ . '/BendaharaBaseController.php';
require_once __DIR__ . '/../models/Ref.php';
require_once __DIR__ . '/../models/Pembayaran.php';

class BendaharaController extends BendaharaBaseController {
    private function opsi(): array {
        return Ref::opsi('pembayaran', 'status_pembayaran', ['menunggu', 'lunas', 'ditolak']);
    }

    public function dashboard(): void {
        $this->renderBendahara('dashboard', ['user' => userLogin(), 'rekap' => Ref::rekap('pembayaran', 'status_pembayaran')]);
    }

    public function pembayaran(): void {
        $q      = trim($_GET['q'] ?? '');
        $status = $_GET['status'] ?? '';
        $opsi   = $this->opsi();
        $daftar = Pembayaran::semua();

        if ($q !== '') {
            $daftar = array_values(array_filter($daftar, function ($b) use ($q) {
                return mb_stripos((string)($b['nama_lengkap'] ?? ''), $q) !== false;
            }));
        }
        if ($status !== '' && in_array($status, $opsi, true)) {
            $daftar = array_values(array_filter($daftar, fn($b) => $b['status_pembayaran'] === $status));
        } else {
            $status = '';
        }

        $this->renderBendahara('pembayaran', [
            'daftar' => $daftar, 'opsi' => $opsi, 'q' => $q, 'status' => $status,
        ]);
    }

    public function ubah(): void {
        $back = 'index.php?c=bendahara&a=pembayaran';
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid.', 'err');
            redirect($back);
        }
        $s = $_POST['status'] ?? '';
        if (!in_array($s, $this->opsi(), true)) {
            flash('Status tidak valid.', 'err');
            redirect($back);
        }
        Pembayaran::setStatus((int)($_POST['id'] ?? 0), $s, trim($_POST['catatan'] ?? ''), (int)userLogin()['id_user']);
        flash('Status pembayaran diperbarui.');
        redirect($back);
    }
}