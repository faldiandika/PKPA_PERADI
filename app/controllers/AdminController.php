<?php
require_once __DIR__ . '/AdminBaseController.php';

class AdminController extends AdminBaseController {
    public function dashboard(): void {
        $this->renderAdmin('dashboard', ['user' => userLogin()]);
    }
}