<?php
require_once __DIR__ . '/KetuaBaseController.php';
require_once __DIR__ . '/../models/Ref.php';
require_once __DIR__ . '/../models/Pendaftaran.php';

class KetuaController extends KetuaBaseController {
    public function dashboard(): void {
        $this->renderKetua('dashboard', [
            'user'        => userLogin(),
            'jmlPeserta'  => Ref::hitung('peserta'),
            'jmlJadwal'   => Ref::hitung('jadwal_sumpah'),
            'pendaftaran' => Ref::rekap('pendaftaran', 'status_pendaftaran'),
            'pembayaran'  => Ref::rekap('pembayaran', 'status_pembayaran'),
            'sumpah'      => Ref::rekap('pengajuan_sumpah', 'status_pemberkasan'),
        ]);
    }

    public function peserta(): void {
        $this->renderKetua('peserta', ['daftar' => Pendaftaran::laporan()]);
    }
}