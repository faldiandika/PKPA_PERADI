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
}