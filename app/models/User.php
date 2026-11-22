<?php
class User {
    public static function findByEmail(string $email): ?array {
        $st = getDB()->prepare("SELECT * FROM users WHERE email = ?");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public static function attempt(string $email, string $password): ?array {
        $u = self::findByEmail($email);
        if ($u && $u['status'] === 'aktif' && password_verify($password, $u['password'])) {
            return $u;
        }
        return null;
    }

    /** Registrasi hanya untuk peserta; role lain dibuat oleh admin. */
    public static function createPeserta(string $nama, string $email, string $password): int {
        $st = getDB()->prepare(
            "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'peserta')"
        );
        $st->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int)getDB()->lastInsertId();
    }
}