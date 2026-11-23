
<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/PengajuanSumpah.php';
require_once __DIR__ . '/../models/DokumenSumpah.php';
require_once __DIR__ . '/../models/JadwalSumpah.php';
require_once __DIR__ . '/../models/DokumenPeserta.php';
require_once __DIR__ . '/../models/Pembayaran.php';

class PengajuanSumpahController extends PesertaBaseController {
    private const JENIS = [
        'KTP',
        'KK',
        'Sertifikat PKPA',
        'Sertifikat UPA',
        'Surat Keterangan Magang'
    ];

    public function index(): void {
        [$p, $d] = $this->wajibPendaftaran();

        $pengajuan = PengajuanSumpah::byPeserta((int)$p['id_peserta']);
        $dokumen = $jadwal = null;

        if ($pengajuan) {
            $id = (int)$pengajuan['id_pengajuan_sumpah'];
            $dokumen = DokumenSumpah::byPengajuan($id);
            $jadwal = JadwalSumpah::byPengajuan($id);
        }

        $this->renderPeserta('sumpah', [
            'pengajuan' => $pengajuan,
            'dokumen' => $dokumen,
            'jadwal' => $jadwal,
            'jenis' => self::JENIS,
            'statusCol' => Ref::statusCol('dokumen_sumpah'),
        ]);
    }

    public function ajukan(): void {
        $this->wajibPost('index.php?c=pengajuansumpah&a=index');
        [$p, $d] = $this->wajibPendaftaran();

        if (!PengajuanSumpah::byPeserta((int)$p['id_peserta'])) {

            // Periksa pembayaran
            $pembayaran = Pembayaran::byPendaftaran(
                (int)$d['id_pendaftaran']
            );

            $sudahDiverifikasi = false;

            foreach ($pembayaran as $bayar) {
                if ($bayar['status_pembayaran'] === 'diverifikasi') {
                    $sudahDiverifikasi = true;
                    break;
                }
            }

            if (!$sudahDiverifikasi) {
                flash('Pembayaran harus diverifikasi Bendahara terlebih dahulu.', 'err');
                redirect('index.php?c=pembayaran&a=index');
            }

            // Periksa kelengkapan dokumen peserta
            $wajib = [
                'Ijazah Sarjana Hukum',
                'KTP',
                'Kartu Keluarga',
                'Transkrip Nilai'
            ];

            $dokumen = DokumenPeserta::byPendaftaran(
                (int)$d['id_pendaftaran']
            );

            $statusDokumen = [];

            foreach ($dokumen as $item) {
                if (!isset($statusDokumen[$item['jenis_dokumen']])) {
                    $statusDokumen[$item['jenis_dokumen']] = $item['status_verifikasi'];
                }
            }

            $belum = [];

            foreach ($wajib as $jenis) {
                if (($statusDokumen[$jenis] ?? '') !== 'lengkap') {
                    $belum[] = $jenis;
                }
            }

    if (!empty($belum)) {
        flash(
            'Dokumen belum diverifikasi lengkap oleh Admin: ' . implode(', ', $belum),
            'err'
        );
        redirect('index.php?c=dokumen&a=index');
    }

            PengajuanSumpah::buat((int)$p['id_peserta']);
            flash('Pengajuan sumpah berhasil dibuat.');
        }

        redirect('index.php?c=pengajuansumpah&a=index');
    }

    public function upload(): void {
        $this->wajibPost('index.php?c=pengajuansumpah&a=index');
        [$p, $d] = $this->wajibPendaftaran();

        $pengajuan = PengajuanSumpah::byPeserta((int)$p['id_peserta']);
        $jenis = $_POST['jenis'] ?? '';

        if (!$pengajuan || !in_array($jenis, self::JENIS, true)) {
            flash('Permintaan tidak valid.', 'err');
            redirect('index.php?c=pengajuansumpah&a=index');
        }

        $idPengajuan = (int)$pengajuan['id_pengajuan_sumpah'];

        // Periksa apakah jenis dokumen sudah pernah diunggah
        $lama = DokumenSumpah::byJenis($idPengajuan, $jenis);

        if ($lama && $lama['status_verifikasi'] !== 'revisi') {
            flash('Berkas ini sudah diunggah dan tidak dapat diunggah ulang.', 'err');
            redirect('index.php?c=pengajuansumpah&a=index');
        }

        $f = $_FILES['file'] ?? ['error' => UPLOAD_ERR_NO_FILE];

        $h = uploadFile(
            $f,
            'dokumen_sumpah',
            ['pdf', 'jpg', 'jpeg', 'png'],
            5 * 1024 * 1024
        );

        if (!$h['ok']) {
            flash($h['pesan'], 'err');
            redirect('index.php?c=pengajuansumpah&a=index');
        }

        $path = 'uploads/dokumen_sumpah/' . $h['nama'];

        if ($lama) {
            DokumenSumpah::perbarui(
                (int)$lama['id_dokumen_sumpah'],
                $f['name'],
                $path
            );
        } else {
            DokumenSumpah::tambah(
                $idPengajuan,
                $jenis,
                $f['name'],
                $path
            );
        }

        flash('Berkas sumpah berhasil diunggah.');
        redirect('index.php?c=pengajuansumpah&a=index');
    }
}