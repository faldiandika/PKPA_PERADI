<?php
class JadwalSumpah {
    public static function byPengajuan(int $id): ?array {
        $st = getDB()->prepare('SELECT * FROM jadwal_sumpah WHERE id_pengajuan_sumpah = ? LIMIT 1');
        $st->execute([$id]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function simpan(int $id, string $tgl, string $waktu, string $tempat, string $ket): void {
        if (self::byPengajuan($id)) {
            getDB()->prepare(
                'UPDATE jadwal_sumpah SET tanggal_sumpah=?, waktu_sumpah=?, tempat_sumpah=?, keterangan=? WHERE id_pengajuan_sumpah=?'
            )->execute([$tgl, $waktu, $tempat, $ket, $id]);
        } else {
            getDB()->prepare(
                'INSERT INTO jadwal_sumpah (id_pengajuan_sumpah, tanggal_sumpah, waktu_sumpah, tempat_sumpah, keterangan)
                 VALUES (?, ?, ?, ?, ?)'
            )->execute([$id, $tgl, $waktu, $tempat, $ket]);
        }
    }
}