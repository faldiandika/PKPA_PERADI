<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Ref.php';
require_once __DIR__ . '/../models/Peserta.php';
require_once __DIR__ . '/../models/Pendaftaran.php';
require_once __DIR__ . '/../helpers/upload.php';

abstract class PesertaBaseController extends Controller {
    public function __construct() {
        wajibRole('peserta');
    }

    protected function renderPeserta(string $view, array $data = []): void {
        $this->render("peserta/$view", $data, 'peserta/layout');
    }

    protected function wajibPendaftaran(): array {
        $u = userLogin();
        $p = Peserta::findByUser((int)$u['id_user']);
        if (!$p) {
            flash('Isi biodata terlebih dahulu.', 'err');
            redirect('index.php?c=peserta&a=biodata');
        }
        $d = Pendaftaran::findByPeserta((int)$p['id_peserta']);
        if (!$d) {
            flash('Daftar PKPA terlebih dahulu.', 'err');
            redirect('index.php?c=pendaftaran&a=index');
        }
        return [$p, $d];
    }

    protected function wajibPost(string $kembali): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid, coba lagi.', 'err');
            redirect($kembali);
        }
    }
}