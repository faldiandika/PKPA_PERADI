<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/Pembayaran.php';

class PembayaranController extends PesertaBaseController {
    private const JUMLAH = 250000;
    private const METODE = ['Transfer Bank', 'Tunai'];
    // GANTI dengan data rekening resmi DPC (dikonfirmasi ke narasumber).
    private const REKENING = 'Bank ........ No. Rek ........ a.n. DPC PERADI Kota Palu';

    private static function sudahAda(array $daftar): bool {
        foreach ($daftar as $b) {
            if (in_array($b['status_pembayaran'], ['menunggu', 'diverifikasi'], true)) return true;
        }
        return false;
    }

    public function index(): void {
        [$p, $d] = $this->wajibPendaftaran();
        $daftar = Pembayaran::byPendaftaran((int)$d['id_pendaftaran']);
        $this->renderPeserta('pembayaran', [
            'pembayaran' => $daftar,
            'jumlah'     => self::JUMLAH,
            'metode'     => self::METODE,
            'rekening'   => self::REKENING,
            'bisaKirim'  => !self::sudahAda($daftar),
        ]);
    }

    public function upload(): void {
        $this->wajibPost('index.php?c=pembayaran&a=index');
        [$p, $d] = $this->wajibPendaftaran();
        if (self::sudahAda(Pembayaran::byPendaftaran((int)$d['id_pendaftaran']))) {
            flash('Bukti pembayaran sudah dikirim dan masih diproses atau sudah terverifikasi.', 'err');
            redirect('index.php?c=pembayaran&a=index');
        }
        $metode = $_POST['metode'] ?? '';
        if (!in_array($metode, self::METODE, true)) {
            flash('Metode pembayaran tidak valid.', 'err');
            redirect('index.php?c=pembayaran&a=index');
        }
        $h = uploadFile($_FILES['bukti'] ?? ['error' => UPLOAD_ERR_NO_FILE], 'bukti', ['jpg', 'jpeg', 'png', 'pdf'], 3 * 1024 * 1024);
        if (!$h['ok']) {
            flash($h['pesan'], 'err');
            redirect('index.php?c=pembayaran&a=index');
        }
        Pembayaran::tambah((int)$d['id_pendaftaran'], self::JUMLAH, $metode, $h['nama']);
        flash('Bukti pembayaran terkirim. Menunggu verifikasi bendahara.');
        redirect('index.php?c=pembayaran&a=index');
    }
}