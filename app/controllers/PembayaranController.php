<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/Pembayaran.php';

class PembayaranController extends PesertaBaseController {
    private const METODE = ['Transfer Bank'];

    private static function config(): array {
        static $cfg = null;
        if ($cfg === null) {
            $cfg = require __DIR__ . '/../../config/rekening.php';
        }
        return $cfg;
    }

    private static function jumlah(): int {
        return (int)self::config()['biaya'];
    }

    private static function rekening(): string {
        $c = self::config();
        return $c['bank'] . ' No. Rek ' . $c['nomor'] . ' a.n. ' . $c['atas_nama'];
    }

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
            'jumlah'     => self::jumlah(),
            'metode'     => self::METODE,
            'rekening'   => self::rekening(),
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
        Pembayaran::tambah((int)$d['id_pendaftaran'], self::jumlah(), $metode, $h['nama']);
        flash('Bukti pembayaran terkirim. Menunggu verifikasi bendahara.');
        redirect('index.php?c=pembayaran&a=index');
    }
}