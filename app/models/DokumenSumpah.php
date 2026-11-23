<?php
class DokumenSumpah {
    public static function byPengajuan(int $id): array {
        $st = getDB()->prepare(
            'SELECT * FROM dokumen_sumpah
             WHERE id_pengajuan_sumpah = ?
             ORDER BY id_dokumen_sumpah DESC'
        );
        $st->execute([$id]);
        return $st->fetchAll();
    }

    public static function byJenis(int $idPengajuan, string $jenis): ?array {
        $st = getDB()->prepare(
            'SELECT * FROM dokumen_sumpah
             WHERE id_pengajuan_sumpah = ? AND jenis_dokumen = ?
             ORDER BY id_dokumen_sumpah DESC LIMIT 1'
        );
        $st->execute([$idPengajuan, $jenis]);
        $data = $st->fetch();
        return $data ?: null;
    }

    public static function tambah(int $idPengajuan, string $jenis, string $nama, string $path): void {
        getDB()->prepare(
            'INSERT INTO dokumen_sumpah
             (id_pengajuan_sumpah, jenis_dokumen, nama_file, file_path)
             VALUES (?, ?, ?, ?)'
        )->execute([$idPengajuan, $jenis, $nama, $path]);
    }

    public static function perbarui(int $id, string $nama, string $path): void {
        $c = Ref::statusCol('dokumen_sumpah');

        $sql = 'UPDATE dokumen_sumpah
                SET nama_file = ?, file_path = ?';

        if ($c) {
            $sql .= ", `$c` = 'menunggu'";
        }

        if (Ref::hasCol('dokumen_sumpah', 'verified_at')) {
            $sql .= ', verified_at = NULL';
        }

        $sql .= ' WHERE id_dokumen_sumpah = ?';

        getDB()->prepare($sql)->execute([$nama, $path, $id]);
    }

    public static function setStatus(int $id, string $status): void {
        $c = Ref::statusCol('dokumen_sumpah');
        if (!$c) return;

        $sql = "UPDATE dokumen_sumpah SET `$c` = ?";

        if (Ref::hasCol('dokumen_sumpah', 'verified_at')) {
            $sql .= ', verified_at = NOW()';
        }

        getDB()->prepare($sql . ' WHERE id_dokumen_sumpah = ?')
            ->execute([$status, $id]);
    }
}