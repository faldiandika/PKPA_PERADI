<?php
class Peserta {

    public static function findByUser(int $idUser): ?array {
        $st = getDB()->prepare('SELECT * FROM peserta WHERE id_user = ? LIMIT 1');
        $st->execute([$idUser]);
        $r = $st->fetch();
        return $r ?: null;
    }

    public static function nikTerpakai(string $nik, int $idUser): bool {
        $st = getDB()->prepare('SELECT COUNT(*) FROM peserta WHERE nik = ? AND id_user <> ?');
        $st->execute([$nik, $idUser]);
        return (int)$st->fetchColumn() > 0;
    }

    public static function simpan(int $idUser, array $d): void {
        $pdo = getDB();
        $ada = self::findByUser($idUser);

        if ($ada) {
            $sql = 'UPDATE peserta SET nama_lengkap=?, nik=?, tempat_lahir=?, tanggal_lahir=?, alamat=?,
                    no_telepon=?, perguruan_tinggi=?, nomor_ijazah=?';
            $par = [$d['nama_lengkap'], $d['nik'], $d['tempat_lahir'], $d['tanggal_lahir'], $d['alamat'],
                    $d['no_telepon'], $d['perguruan_tinggi'], $d['nomor_ijazah']];
            if (!empty($d['pas_foto'])) {
                $sql .= ', pas_foto=?';
                $par[] = $d['pas_foto'];
            }
            $sql .= ' WHERE id_user=?';
            $par[] = $idUser;
            $pdo->prepare($sql)->execute($par);
            return;
        }

        $st = $pdo->prepare('SELECT email FROM users WHERE id_user = ?');
        $st->execute([$idUser]);
        $email = (string)$st->fetchColumn();

        $pdo->prepare('INSERT INTO peserta
            (id_user, nama_lengkap, nik, tempat_lahir, tanggal_lahir, alamat, no_telepon, email,
             perguruan_tinggi, nomor_ijazah, pas_foto)
            VALUES (?,?,?,?,?,?,?,?,?,?,?)')
            ->execute([$idUser, $d['nama_lengkap'], $d['nik'], $d['tempat_lahir'], $d['tanggal_lahir'],
                       $d['alamat'], $d['no_telepon'], $email, $d['perguruan_tinggi'],
                       $d['nomor_ijazah'], $d['pas_foto'] ?? '']);
    }
}