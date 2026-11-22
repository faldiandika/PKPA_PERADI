<?php
require_once __DIR__ . '/PesertaBaseController.php';

class PesertaController extends PesertaBaseController {
    public function dashboard(): void {
        $this->renderPeserta('dashboard', ['user' => userLogin()]);
    }
}