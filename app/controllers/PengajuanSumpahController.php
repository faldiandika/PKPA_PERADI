<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/PengajuanSumpah.php';
require_once __DIR__ . '/../models/DokumenSumpah.php';
require_once __DIR__ . '/../models/JadwalSumpah.php';

class PengajuanSumpahController extends PesertaBaseController {
    private const JENIS = ['KTP', 'KK', 'Sertifikat PKPA', 'Sertifikat UPA', 'Surat Keterangan Magang'];

    public function index(): void {
        [$p, $d] = $this->wajibPendaftaran();
        $pengajuan = PengajuanSumpah::byPeserta((int)$p['id_peserta']);
        $dokumen = $jadwal = null;
        if ($pengajuan) {
            $id = (int)$pengajuan['id_pengajuan_sumpah'];
            $dokumen = DokumenSumpah::byPengajuan($id);
            $jadwal  = JadwalSumpah::byPengajuan($id);
        }
        $this->renderPeserta('sumpah', [
            'pengajuan' => $pengajuan, 'dokumen' => $dokumen, 'jadwal' => $jadwal,
            'jenis' => self::JENIS, 'statusCol' => Ref::statusCol('dokumen_sumpah'),
        ]);
    }

    public function ajukan(): void {
        $this->wajibPost('index.php?c=pengajuansumpah&a=index');
        [$p, $d] = $this->wajibPendaftaran();
        if (!PengajuanSumpah::byPeserta((int)$p['id_peserta'])) {
            PengajuanSumpah::buat((int)$p['id_peserta']);
            flash('Pengajuan sumpah dibuat. Silakan unggah berkas.');
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
        $f = $_FILES['file'] ?? ['error' => UPLOAD_ERR_NO_FILE];
        $h = uploadFile($f, 'dokumen_sumpah', ['pdf', 'jpg', 'jpeg', 'png'], 5 * 1024 * 1024);
        if (!$h['ok']) {
            flash($h['pesan'], 'err');
            redirect('index.php?c=pengajuansumpah&a=index');
        }
        DokumenSumpah::tambah((int)$pengajuan['id_pengajuan_sumpah'], $jenis, $f['name'], 'uploads/dokumen_sumpah/' . $h['nama']);
        flash('Berkas sumpah berhasil diunggah.');
        redirect('index.php?c=pengajuansumpah&a=index');
    }
}