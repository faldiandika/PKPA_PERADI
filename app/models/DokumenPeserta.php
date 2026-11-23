
<?php
class DokumenPeserta {
    public static function byPendaftaran(int $id): array {
        $st = getDB()->prepare(
            'SELECT * FROM dokumen_peserta
             WHERE id_pendaftaran = ?
             ORDER BY id_dokumen DESC'
        );
        $st->execute([$id]);
        return $st->fetchAll();
    }

    public static function byJenis(int $idPendaftaran, string $jenis): ?array {
        $st = getDB()->prepare(
            'SELECT * FROM dokumen_peserta
             WHERE id_pendaftaran = ? AND jenis_dokumen = ?
             ORDER BY id_dokumen DESC LIMIT 1'
        );
        $st->execute([$idPendaftaran, $jenis]);
        $data = $st->fetch();

        return $data ?: null;
    }

    public static function tambah(
        int $idPendaftaran,
        string $jenis,
        string $nama,
        string $path
    ): void {
        getDB()->prepare(
            'INSERT INTO dokumen_peserta
             (id_pendaftaran, jenis_dokumen, nama_file, file_path, tanggal_upload)
             VALUES (?, ?, ?, ?, NOW())'
        )->execute([$idPendaftaran, $jenis, $nama, $path]);
    }

    public static function perbarui(
        int $id,
        string $nama,
        string $path
    ): void {
        getDB()->prepare(
            "UPDATE dokumen_peserta
             SET nama_file = ?, file_path = ?, tanggal_upload = NOW(),
                 status_verifikasi = 'menunggu', catatan = NULL,
                 verified_by = NULL, verified_at = NULL
             WHERE id_dokumen = ?"
        )->execute([$nama, $path, $id]);
    }

    public static function setStatus(
        int $id,
        string $status,
        string $catatan,
        int $by
    ): void {
        getDB()->prepare(
            'UPDATE dokumen_peserta
             SET status_verifikasi = ?, catatan = ?, verified_by = ?, verified_at = NOW()
             WHERE id_dokumen = ?'
        )->execute([$status, $catatan, $by, $id]);
    }
}
