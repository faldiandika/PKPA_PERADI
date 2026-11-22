<?php
require_once __DIR__ . '/Controller.php';

abstract class AdminBaseController extends Controller {
    public function __construct() {
        wajibRole('admin');
    }

    protected function renderAdmin(string $view, array $data = []): void {
        $this->render("admin/$view", $data, 'admin/layout');
    }
}