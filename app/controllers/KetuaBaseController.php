<?php
require_once __DIR__ . '/Controller.php';

abstract class KetuaBaseController extends Controller {
    public function __construct() {
        wajibRole('ketua');
    }

    protected function renderKetua(string $view, array $data = []): void {
        $this->render("ketua/$view", $data, 'ketua/layout');
    }
}