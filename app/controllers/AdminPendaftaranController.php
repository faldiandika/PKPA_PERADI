<?php
require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../models/Ref.php';
require_once __DIR__ . '/../models/Pendaftaran.php';
require_once __DIR__ . '/../models/DokumenPeserta.php';

class AdminPendaftaranController extends AdminBaseController {
    private function opsiPendaftaran(): array {
        return Ref::opsi('pendaftaran', 'status_pendaftaran', ['menunggu', 'disetujui', 'ditolak']);
    }
    private function opsiDokumen(): array {
        $c = Ref::statusCol('dokumen_peserta');
        return $c ? Ref::opsi('dokumen_peserta', $c, ['menunggu', 'valid', 'ditolak']) : [];
    }

    public function index(): void {
        $q      = trim($_GET['q'] ?? '');
        $status = $_GET['status'] ?? '';
        $opsi   = $this->opsiPendaftaran();
        $daftar = Pendaftaran::semua();

        if ($q !== '') {
            $daftar = array_values(array_filter($daftar, function ($r) use ($q) {
                foreach (['nama_lengkap', 'nik', 'periode'] as $k) {
                    if (mb_stripos((string)($r[$k] ?? ''), $q) !== false) return true;
                }
                return false;
            }));
        }
        if ($status !== '' && in_array($status, $opsi, true)) {
            $daftar = array_values(array_filter($daftar, fn($r) => $r['status_pendaftaran'] === $status));
        } else {
            $status = '';
        }

        $this->renderAdmin('pendaftaran', [
            'daftar' => $daftar, 'q' => $q, 'status' => $status, 'opsi' => $opsi,
        ]);
    }

    public function detail(): void {
        $id = (int)($_GET['id'] ?? 0);
        $pd = Pendaftaran::find($id);
        if (!$pd) {
            flash('Data tidak ditemukan.', 'err');
            redirect('index.php?c=adminpendaftaran&a=index');
        }
        $this->renderAdmin('detail', [
            'pd' => $pd,
            'dokumen' => DokumenPeserta::byPendaftaran($id),
            'opsiPendaftaran' => $this->opsiPendaftaran(),
            'opsiDokumen' => $this->opsiDokumen(),
            'statusCol' => Ref::statusCol('dokumen_peserta'),
        ]);
    }

    public function status(): void {
        $id = (int)($_POST['id'] ?? 0);
        $back = 'index.php?c=adminpendaftaran&a=detail&id=' . $id;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid.', 'err');
            redirect($back);
        }
        $s = $_POST['status'] ?? '';
        if (!in_array($s, $this->opsiPendaftaran(), true)) {
            flash('Status tidak valid.', 'err');
            redirect($back);
        }
        Pendaftaran::setStatus($id, $s, trim($_POST['catatan'] ?? ''), (int)userLogin()['id_user']);
        flash('Status pendaftaran diperbarui.');
        redirect($back);
    }

    public function dokumen(): void {
        $id = (int)($_POST['id_pendaftaran'] ?? 0);
        $back = 'index.php?c=adminpendaftaran&a=detail&id=' . $id;
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid.', 'err');
            redirect($back);
        }
        $s = $_POST['status'] ?? '';
        if (!in_array($s, $this->opsiDokumen(), true)) {
            flash('Status tidak valid.', 'err');
            redirect($back);
        }
        DokumenPeserta::setStatus((int)($_POST['id_dokumen'] ?? 0), $s, trim($_POST['catatan'] ?? ''), (int)userLogin()['id_user']);
        flash('Status dokumen diperbarui.');
        redirect($back);
    }
}