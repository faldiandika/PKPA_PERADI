
<?php
class User {
    public static function findByEmail(string $email): ?array {
        $st = getDB()->prepare("SELECT * FROM users WHERE email = ?");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public static function findById(int $id): ?array {
        $st = getDB()->prepare("SELECT * FROM users WHERE id_user = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public static function attempt(string $email, string $password): ?array {
        $u = self::findByEmail($email);
        if ($u && $u['status'] === 'aktif' && password_verify($password, $u['password'])) {
            return $u;
        }
        return null;
    }

    public static function createPeserta(string $nama, string $email, string $password): int {
        $st = getDB()->prepare(
            "INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, 'peserta')"
        );
        $st->execute([$nama, $email, password_hash($password, PASSWORD_DEFAULT)]);
        return (int)getDB()->lastInsertId();
    }

    public static function emailDipakai(string $email, int $id): bool {
        $st = getDB()->prepare(
            "SELECT id_user FROM users WHERE email = ? AND id_user != ?"
        );
        $st->execute([$email, $id]);
        return (bool)$st->fetch();
    }

    public static function updateProfil(int $id, string $nama, string $email): bool {
        $st = getDB()->prepare(
            "UPDATE users SET nama = ?, email = ? WHERE id_user = ?"
        );
        return $st->execute([$nama, $email, $id]);
    }

    public static function updatePassword(int $id, string $password): bool {
        $st = getDB()->prepare(
            "UPDATE users SET password = ? WHERE id_user = ?"
        );
        return $st->execute([
            password_hash($password, PASSWORD_DEFAULT),
            $id
        ]);
    }
}
