<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/DokumenPeserta.php';

class DokumenController extends PesertaBaseController {
    private const JENIS = ['Ijazah Sarjana Hukum', 'KTP', 'Kartu Keluarga', 'Transkrip Nilai'];

    public function index(): void {
        [$p, $d] = $this->wajibPendaftaran();
        $this->renderPeserta('dokumen', [
            'dokumen'   => DokumenPeserta::byPendaftaran((int)$d['id_pendaftaran']),
            'jenis'     => self::JENIS,
            'statusCol' => Ref::statusCol('dokumen_peserta'),
        ]);
    }

    public function upload(): void {
        $this->wajibPost('index.php?c=dokumen&a=index');
        [$p, $d] = $this->wajibPendaftaran();
        $jenis = $_POST['jenis'] ?? '';
        if (!in_array($jenis, self::JENIS, true)) {
            flash('Jenis dokumen tidak valid.', 'err');
            redirect('index.php?c=dokumen&a=index');
        }
        $f = $_FILES['file'] ?? ['error' => UPLOAD_ERR_NO_FILE];
        $h = uploadFile($f, 'dokumen', ['pdf', 'jpg', 'jpeg', 'png'], 5 * 1024 * 1024);
        if (!$h['ok']) {
            flash($h['pesan'], 'err');
            redirect('index.php?c=dokumen&a=index');
        }
        DokumenPeserta::tambah((int)$d['id_pendaftaran'], $jenis, $f['name'], 'uploads/dokumen/' . $h['nama']);
        flash('Dokumen berhasil diunggah.');
        redirect('index.php?c=dokumen&a=index');
    }
}