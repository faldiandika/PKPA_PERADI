<?php
class PengajuanSumpah {
    public static function byPeserta(int $idPeserta): ?array {
        $st = getDB()->prepare('SELECT * FROM pengajuan_sumpah WHERE id_peserta = ? ORDER BY id_pengajuan_sumpah DESC LIMIT 1');
        $st->execute([$idPeserta]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function buat(int $idPeserta): void {
        getDB()->prepare(
            "INSERT INTO pengajuan_sumpah (id_peserta, tanggal_pengajuan, status_pemberkasan, catatan)
             VALUES (?, NOW(), 'menunggu', 'Pengajuan sumpah menunggu pemeriksaan berkas oleh admin.')"
        )->execute([$idPeserta]);
    }

    public static function semua(): array {
        return getDB()->query(
            'SELECT s.*, p.nama_lengkap FROM pengajuan_sumpah s
             JOIN peserta p ON p.id_peserta = s.id_peserta ORDER BY s.id_pengajuan_sumpah DESC'
        )->fetchAll();
    }

    public static function find(int $id): ?array {
        $st = getDB()->prepare(
            'SELECT s.*, p.nama_lengkap, p.nik FROM pengajuan_sumpah s
             JOIN peserta p ON p.id_peserta = s.id_peserta WHERE s.id_pengajuan_sumpah = ?'
        );
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function setStatus(
        int $id,
        string $status,
        string $catatan,
        int $idAdmin
    ): void {
        getDB()->prepare(
            'UPDATE pengajuan_sumpah
             SET status_pemberkasan = ?,
                 catatan = ?,
                 verified_by = ?,
                 verified_at = NOW()
             WHERE id_pengajuan_sumpah = ?'
        )->execute([$status, $catatan, $idAdmin, $id]);
    }
}