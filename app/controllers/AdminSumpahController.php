
<?php
require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../models/Ref.php';
require_once __DIR__ . '/../models/PengajuanSumpah.php';
require_once __DIR__ . '/../models/DokumenSumpah.php';
require_once __DIR__ . '/../models/JadwalSumpah.php';

class AdminSumpahController extends AdminBaseController {

    private function opsiPengajuan(): array {
        return Ref::opsi(
            'pengajuan_sumpah',
            'status_pemberkasan',
            ['menunggu', 'diperiksa', 'perbaikan', 'dikirim', 'diterima', 'ditolak']
        );
    }

    private function opsiDokumen(): array {
        $c = Ref::statusCol('dokumen_sumpah');

        return $c
            ? Ref::opsi('dokumen_sumpah', $c, ['menunggu', 'lengkap', 'revisi', 'ditolak'])
            : [];
    }

    private function mulaiPost(int $id): string {
        $back = 'index.php?c=adminsumpah&a=detail&id=' . $id;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valid()) {
            flash('Sesi tidak valid.', 'err');
            redirect($back);
        }

        return $back;
    }

    public function index(): void {
        $this->renderAdmin('sumpah', [
            'daftar' => PengajuanSumpah::semua()
        ]);
    }

    public function detail(): void {
        $id = (int)($_GET['id'] ?? 0);
        $s = PengajuanSumpah::find($id);

        if (!$s) {
            flash('Data tidak ditemukan.', 'err');
            redirect('index.php?c=adminsumpah&a=index');
        }

        $this->renderAdmin('sumpah_detail', [
            's' => $s,
            'dokumen' => DokumenSumpah::byPengajuan($id),
            'jadwal' => JadwalSumpah::byPengajuan($id),
            'opsiPengajuan' => $this->opsiPengajuan(),
            'opsiDokumen' => $this->opsiDokumen(),
            'statusCol' => Ref::statusCol('dokumen_sumpah'),
        ]);
    }

    public function status(): void {
        $id = (int)($_POST['id'] ?? 0);
        $back = $this->mulaiPost($id);
        $st = $_POST['status'] ?? '';

        if (!in_array($st, $this->opsiPengajuan(), true)) {
            flash('Status tidak valid.', 'err');
            redirect($back);
        }

        $u = userLogin();

        PengajuanSumpah::setStatus(
            $id,
            $st,
            trim($_POST['catatan'] ?? ''),
            (int)$u['id_user']
        );

        flash('Status pemberkasan diperbarui.');
        redirect($back);
    }

    public function dokumen(): void {
        $id = (int)($_POST['id'] ?? 0);
        $back = $this->mulaiPost($id);
        $st = $_POST['status'] ?? '';

        if (!in_array($st, $this->opsiDokumen(), true)) {
            flash('Status tidak valid.', 'err');
            redirect($back);
        }

        $u = userLogin();

        DokumenSumpah::setStatus(
            (int)($_POST['id_dokumen_sumpah'] ?? 0),
            $st,
            (int)$u['id_user']
        );

        flash('Status berkas diperbarui.');
        redirect($back);
    }

    public function jadwal(): void {
        $id = (int)($_POST['id'] ?? 0);
        $back = $this->mulaiPost($id);

        $tgl = trim($_POST['tanggal'] ?? '');
        $wkt = trim($_POST['waktu'] ?? '');
        $tmp = trim($_POST['tempat'] ?? '');

        // Validasi dan konversi DD-MM-YYYY ke YYYY-MM-DD
        $d = DateTime::createFromFormat('!d-m-Y', $tgl);

        if (
            !$d ||
            $d->format('d-m-Y') !== $tgl ||
            $wkt === '' ||
            $tmp === ''
        ) {
            flash('Tanggal, waktu, dan tempat wajib diisi dengan benar. Gunakan format DD-MM-YYYY.', 'err');
            redirect($back);
        }

        $tglDatabase = $d->format('Y-m-d');

        JadwalSumpah::simpan(
            $id,
            $tglDatabase,
            $wkt,
            $tmp,
            trim($_POST['keterangan'] ?? '')
        );

        flash('Jadwal sumpah disimpan.');
        redirect($back);
    }
}
