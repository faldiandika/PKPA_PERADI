<?php
class Ref {
    public static function statusCol(string $t): ?string {
        foreach (getDB()->query("SHOW COLUMNS FROM `$t`")->fetchAll() as $c) {
            if (strpos($c['Field'], 'status') === 0) return $c['Field'];
        }
        return null;
    }
    public static function hasCol(string $t, string $col): bool {
        foreach (getDB()->query("SHOW COLUMNS FROM `$t`")->fetchAll() as $c) {
            if ($c['Field'] === $col) return true;
        }
        return false;
    }
    public static function opsi(string $t, string $col, array $fallback): array {
        foreach (getDB()->query("SHOW COLUMNS FROM `$t`")->fetchAll() as $c) {
            if ($c['Field'] === $col && preg_match_all("/'([^']*)'/", $c['Type'], $m) && $m[1]) {
                return $m[1];
            }
        }
        return $fallback;
    }
    public static function rekap(string $t, string $col): array {
        return getDB()->query("SELECT `$col` AS s, COUNT(*) AS n FROM `$t` GROUP BY `$col`")->fetchAll();
    }
    public static function hitung(string $t): int {
        return (int)getDB()->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
    }
}