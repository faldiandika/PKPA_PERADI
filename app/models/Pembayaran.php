<?php
class Pembayaran {
    public static function byPendaftaran(int $id): array {
        $st = getDB()->prepare('SELECT * FROM pembayaran WHERE id_pendaftaran = ? ORDER BY id_pembayaran DESC');
        $st->execute([$id]);
        return $st->fetchAll();
    }

    public static function tambah(int $idPendaftaran, float $jumlah, string $metode, string $bukti): void {
        getDB()->prepare(
            "INSERT INTO pembayaran (id_pendaftaran, tanggal_bayar, jumlah, metode_pembayaran, bukti_pembayaran, status_pembayaran)
             VALUES (?, NOW(), ?, ?, ?, 'menunggu')"
        )->execute([$idPendaftaran, $jumlah, $metode, $bukti]);
    }

    public static function semua(): array {
        return getDB()->query(
            'SELECT b.*, p.nama_lengkap, pd.periode FROM pembayaran b
             JOIN pendaftaran pd ON pd.id_pendaftaran = b.id_pendaftaran
             JOIN peserta p ON p.id_peserta = pd.id_peserta
             ORDER BY b.id_pembayaran DESC'
        )->fetchAll();
    }

    public static function setStatus(int $id, string $status, string $catatan, int $by): void {
        getDB()->prepare('UPDATE pembayaran SET status_pembayaran = ?, catatan = ?, verified_by = ?, verified_at = NOW() WHERE id_pembayaran = ?')
            ->execute([$status, $catatan, $by, $id]);
    }
}