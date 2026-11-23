<?php
require_once __DIR__ . '/PesertaBaseController.php';
require_once __DIR__ . '/../models/Peserta.php';
require_once __DIR__ . '/../models/Pendaftaran.php';
require_once __DIR__ . '/../models/DokumenPeserta.php';
require_once __DIR__ . '/../models/Pembayaran.php';
require_once __DIR__ . '/../helpers/upload.php';

class PesertaController extends PesertaBaseController {

    public function dashboard(): void {
        $u = userLogin();
        $peserta = Peserta::findByUser((int)$u['id_user']);
        $this->renderPeserta('dashboard', ['user' => $u, 'peserta' => $peserta, 'notif' => $this->notifikasi($peserta)]);
    }

    private function notifikasi(?array $p): array {
        if (!$p) return [['info', 'Lengkapi biodata Anda terlebih dahulu di menu Biodata.']];
        $d = Pendaftaran::findByPeserta((int)$p['id_peserta']);
        if (!$d) return [['info', 'Anda belum mendaftar PKPA. Silakan daftar di menu Pendaftaran.']];

        $n = [];
        $cat = trim((string)($d['catatan'] ?? ''));
        $tambah = $cat !== '' ? ' Catatan: ' . $cat : '';
        switch ($d['status_pendaftaran']) {
            case 'diterima': $n[] = ['ok', 'Pendaftaran Anda telah diterima.']; break;
            case 'revisi':   $n[] = ['warn', 'Pendaftaran perlu perbaikan.' . $tambah]; break;
            case 'ditolak':  $n[] = ['err', 'Pendaftaran ditolak.' . $tambah]; break;
            default:         $n[] = ['info', 'Pendaftaran menunggu verifikasi admin.'];
        }

        $id = (int)$d['id_pendaftaran'];
        $dokumen = DokumenPeserta::byPendaftaran($id);
        if (!$dokumen) $n[] = ['info', 'Belum ada dokumen yang diunggah.'];
        $terlihat = [];
        foreach ($dokumen as $x) {
            if (isset($terlihat[$x['jenis_dokumen']])) continue;   // hanya unggahan terbaru per jenis
            $terlihat[$x['jenis_dokumen']] = true;
            $st = $x['status_verifikasi'] ?? '';
            if ($st === 'revisi' || $st === 'ditolak') {
                $c = trim((string)($x['catatan'] ?? ''));
                $n[] = ['warn', 'Dokumen ' . $x['jenis_dokumen'] . ' ' . $st . '.' . ($c !== '' ? ' Catatan: ' . $c : '') . ' Silakan unggah ulang.'];
            }
        }

        $bayar = Pembayaran::byPendaftaran($id);
        if (!$bayar) {
            $n[] = ['info', 'Belum ada bukti pembayaran.'];
        } else {
            $s = $bayar[0]['status_pembayaran'];
            $c = trim((string)($bayar[0]['catatan'] ?? ''));
            if ($s === 'diverifikasi')  $n[] = ['ok', 'Pembayaran Anda telah terverifikasi.'];
            elseif ($s === 'ditolak')   $n[] = ['err', 'Pembayaran ditolak.' . ($c !== '' ? ' Catatan: ' . $c : '') . ' Silakan kirim ulang bukti.'];
            else                        $n[] = ['info', 'Bukti pembayaran menunggu verifikasi bendahara.'];
        }
        return $n;
    }

    public function biodata(): void {
        $u      = userLogin();
        $idUser = (int)$u['id_user'];
        $peserta = Peserta::findByUser($idUser);
        $error  = '';

        $isi = $peserta ?? [
            'nama_lengkap' => $u['nama'], 'nik' => '', 'tempat_lahir' => '', 'tanggal_lahir' => '',
            'alamat' => '', 'no_telepon' => '', 'perguruan_tinggi' => '', 'nomor_ijazah' => '', 'pas_foto' => '',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (['nama_lengkap', 'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat',
                      'no_telepon', 'perguruan_tinggi', 'nomor_ijazah'] as $k) {
                $isi[$k] = trim($_POST[$k] ?? '');
            }

            $tgl = DateTime::createFromFormat('Y-m-d', $isi['tanggal_lahir']);
            $tglValid = $tgl && $tgl->format('Y-m-d') === $isi['tanggal_lahir'];

            if (!csrf_valid()) {
                $error = 'Sesi tidak valid, coba lagi.';
            } elseif ($isi['nama_lengkap'] === '') {
                $error = 'Nama lengkap wajib diisi.';
            } elseif (!preg_match('/^\d{16}$/', $isi['nik'])) {
                $error = 'NIK harus 16 digit angka.';
            } elseif (Peserta::nikTerpakai($isi['nik'], $idUser)) {
                $error = 'NIK sudah dipakai peserta lain.';
            } elseif ($isi['tempat_lahir'] === '' || !$tglValid) {
                $error = 'Tempat dan tanggal lahir wajib diisi dengan benar.';
            } elseif ($isi['alamat'] === '') {
                $error = 'Alamat wajib diisi.';
            } elseif (!preg_match('/^[0-9+]{8,15}$/', $isi['no_telepon'])) {
                $error = 'No. telepon harus 8 sampai 15 digit.';
            } elseif ($isi['perguruan_tinggi'] === '' || $isi['nomor_ijazah'] === '') {
                $error = 'Perguruan tinggi dan nomor ijazah wajib diisi.';
            }

            $fotoBaru = '';
            if ($error === '') {
                $hasil = uploadFile($_FILES['pas_foto'] ?? ['error' => UPLOAD_ERR_NO_FILE],
                                    'pas_foto', ['jpg', 'jpeg', 'png'], 2 * 1024 * 1024);
                if ($hasil['ok']) {
                    $fotoBaru = $hasil['nama'];
                } elseif (!$hasil['kosong']) {
                    $error = $hasil['pesan'];
                } elseif (!$peserta || ($peserta['pas_foto'] ?? '') === '') {
                    $error = 'Pas foto wajib diunggah.';
                }
            }

            if ($error === '') {
                $data = $isi;
                $data['pas_foto'] = $fotoBaru;
                Peserta::simpan($idUser, $data);
                if ($fotoBaru !== '' && $peserta && ($peserta['pas_foto'] ?? '') !== '') {
                    hapusFile('pas_foto', $peserta['pas_foto']);
                }
                flash('Biodata berhasil disimpan.');
                redirect('index.php?c=peserta&a=biodata');
            }
        }

        $this->renderPeserta('biodata', ['peserta' => $peserta, 'isi' => $isi, 'error' => $error]);
    }
}