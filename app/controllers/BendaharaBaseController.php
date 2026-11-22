<?php
require_once __DIR__ . '/Controller.php';

abstract class BendaharaBaseController extends Controller {
    public function __construct() {
        wajibRole('bendahara');
    }

    protected function renderBendahara(string $view, array $data = []): void {
        $this->render("bendahara/$view", $data, 'bendahara/layout');
    }
}