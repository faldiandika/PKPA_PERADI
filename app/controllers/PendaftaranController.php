<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/Peserta.php';
require_once __DIR__ . '/../models/Pendaftaran.php';

class PendaftaranController extends PesertaBaseController {

    private const PERIODE = 'PKPA 2026';

    public function index(): void {
        $u = userLogin();
        $peserta = Peserta::findByUser((int)$u['id_user']);
        if (!$peserta) {
            flash('Isi biodata terlebih dahulu.', 'err');
            redirect('index.php?c=peserta&a=biodata');
        }
        $pendaftaran = Pendaftaran::findByPeserta((int)$peserta['id_peserta']);
        $this->renderPeserta('pendaftaran', [
            'pendaftaran' => $pendaftaran,
            'periode'     => self::PERIODE,
        ]);
    }

    public function daftar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid, coba lagi.', 'err');
            redirect('index.php?c=pendaftaran&a=index');
        }
        $u = userLogin();
        $peserta = Peserta::findByUser((int)$u['id_user']);
        if (!$peserta) {
            flash('Isi biodata terlebih dahulu.', 'err');
            redirect('index.php?c=peserta&a=biodata');
        }
        $idPeserta = (int)$peserta['id_peserta'];
        if (Pendaftaran::findByPeserta($idPeserta)) {
            flash('Anda sudah terdaftar.', 'err');
            redirect('index.php?c=pendaftaran&a=index');
        }
        Pendaftaran::buat($idPeserta, self::PERIODE);
        flash('Pendaftaran berhasil dikirim. Menunggu verifikasi admin.');
        redirect('index.php?c=pendaftaran&a=index');
    }
}