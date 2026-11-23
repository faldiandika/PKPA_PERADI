<?php
require_once __DIR__ . '/AdminBaseController.php';
require_once __DIR__ . '/../models/Ref.php';

class AdminController extends AdminBaseController {
    public function dashboard(): void {
        $this->renderAdmin('dashboard', [
            'user'        => userLogin(),
            'pendaftaran' => Ref::rekap('pendaftaran', 'status_pendaftaran'),
            'sumpah'      => Ref::rekap('pengajuan_sumpah', 'status_pemberkasan'),
        ]);
    }

    public function backup(): void {
        $db = getDB();
        $nama = 'backup_db_pkpa_peradi_' . date('Ymd_His') . '.sql';
        header('Content-Type: application/sql; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $nama . '"');

        echo "-- Backup db_pkpa_peradi, " . date('d-m-Y H:i:s') . "\n";
        echo "SET FOREIGN_KEY_CHECKS=0;\n\n";

        $tabel = $db->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        foreach ($tabel as $t) {
            $create = $db->query("SHOW CREATE TABLE `$t`")->fetch(PDO::FETCH_NUM);
            echo "DROP TABLE IF EXISTS `$t`;\n" . $create[1] . ";\n\n";

            $rows = $db->query("SELECT * FROM `$t`")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $r) {
                $nilai = array_map(fn($v) => $v === null ? 'NULL' : $db->quote((string)$v), array_values($r));
                echo "INSERT INTO `$t` (`" . implode('`,`', array_keys($r)) . "`) VALUES (" . implode(',', $nilai) . ");\n";
            }
            echo "\n";
        }
        echo "SET FOREIGN_KEY_CHECKS=1;\n";
        exit;
    }
    
}