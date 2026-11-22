<?php
require_once __DIR__ . '/KetuaBaseController.php';

class KetuaController extends KetuaBaseController {
    public function dashboard(): void {
        $this->renderKetua('dashboard', ['user' => userLogin()]);
    }
}