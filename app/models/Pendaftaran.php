<?php
class Pendaftaran {
    public static function findByPeserta(int $idPeserta): ?array {
        $st = getDB()->prepare('SELECT * FROM pendaftaran WHERE id_peserta = ? ORDER BY id_pendaftaran DESC LIMIT 1');
        $st->execute([$idPeserta]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function buat(int $idPeserta, string $periode): void {
        getDB()->prepare(
            "INSERT INTO pendaftaran (id_peserta, tanggal_daftar, periode, status_pendaftaran, catatan)
             VALUES (?, NOW(), ?, 'menunggu', 'Pendaftaran menunggu proses verifikasi admin.')"
        )->execute([$idPeserta, $periode]);
    }

    public static function semua(): array {
        return getDB()->query(
            'SELECT pd.*, p.nama_lengkap, p.nik FROM pendaftaran pd
             JOIN peserta p ON p.id_peserta = pd.id_peserta ORDER BY pd.id_pendaftaran DESC'
        )->fetchAll();
    }

    public static function find(int $id): ?array {
        $st = getDB()->prepare(
            'SELECT pd.*, p.nama_lengkap, p.nik, p.tempat_lahir, p.tanggal_lahir, p.alamat, p.no_telepon,
                    p.email, p.perguruan_tinggi, p.nomor_ijazah, p.pas_foto
             FROM pendaftaran pd JOIN peserta p ON p.id_peserta = pd.id_peserta
             WHERE pd.id_pendaftaran = ?'
        );
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function setStatus(int $id, string $status, string $catatan, int $by): void {
        getDB()->prepare('UPDATE pendaftaran SET status_pendaftaran = ?, catatan = ?, verified_by = ?, verified_at = NOW() WHERE id_pendaftaran = ?')
            ->execute([$status, $catatan, $by, $id]);
    }

    public static function laporan(): array {
        return getDB()->query(
            "SELECT p.nama_lengkap, p.perguruan_tinggi, pd.periode, pd.status_pendaftaran,
                    (SELECT b.status_pembayaran FROM pembayaran b
                     WHERE b.id_pendaftaran = pd.id_pendaftaran
                     ORDER BY b.id_pembayaran DESC LIMIT 1) AS status_bayar,
                    (SELECT COALESCE(SUM(b.jumlah), 0) FROM pembayaran b
                     WHERE b.id_pendaftaran = pd.id_pendaftaran AND b.status_pembayaran = 'diverifikasi') AS total_bayar
             FROM pendaftaran pd JOIN peserta p ON p.id_peserta = pd.id_peserta
             ORDER BY pd.periode, p.nama_lengkap"
        )->fetchAll();
    }
}