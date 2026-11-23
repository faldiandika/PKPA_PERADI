<?php
class DokumenSumpah {
    public static function byPengajuan(int $id): array {
        $st = getDB()->prepare('SELECT * FROM dokumen_sumpah WHERE id_pengajuan_sumpah = ? ORDER BY id_dokumen_sumpah DESC');
        $st->execute([$id]);
        return $st->fetchAll();
    }

    public static function tambah(int $idPengajuan, string $jenis, string $nama, string $path): void {
        getDB()->prepare(
            'INSERT INTO dokumen_sumpah (id_pengajuan_sumpah, jenis_dokumen, nama_file, file_path) VALUES (?, ?, ?, ?)'
        )->execute([$idPengajuan, $jenis, $nama, $path]);
    }

    public static function setStatus(int $id, string $status): void {
        $c = Ref::statusCol('dokumen_sumpah');
        if (!$c) return;
        $sql = "UPDATE dokumen_sumpah SET `$c` = ?";
        if (Ref::hasCol('dokumen_sumpah', 'verified_at')) {
            $sql .= ', verified_at = NOW()';
        }
        getDB()->prepare($sql . ' WHERE id_dokumen_sumpah = ?')->execute([$status, $id]);
    }
}