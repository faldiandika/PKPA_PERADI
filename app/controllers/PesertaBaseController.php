<?php
require_once __DIR__ . '/Controller.php';

abstract class PesertaBaseController extends Controller {
    public function __construct() {
        wajibRole('peserta');
    }

    protected function renderPeserta(string $view, array $data = []): void {
        $this->render("peserta/$view", $data, 'peserta/layout');
    }
}