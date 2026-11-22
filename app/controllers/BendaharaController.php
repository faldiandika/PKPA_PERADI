<?php
require_once __DIR__ . '/BendaharaBaseController.php';

class BendaharaController extends BendaharaBaseController {
    public function dashboard(): void {
        $this->renderBendahara('dashboard', ['user' => userLogin()]);
    }
}