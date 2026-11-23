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
        $this->renderBendahara('pembayaran', ['daftar' => Pembayaran::semua(), 'opsi' => $this->opsi()]);
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