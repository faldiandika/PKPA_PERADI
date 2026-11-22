<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/helpers/functions.php';

$c = $_GET['c'] ?? 'auth';
$a = $_GET['a'] ?? 'login';

$peta = [
    'auth'              => 'AuthController',
    'peserta'           => 'PesertaController',
    'pendaftaran'       => 'PendaftaranController',
    'dokumen'           => 'DokumenController',
    'pembayaran'        => 'PembayaranController',
    'pengajuansumpah'   => 'PengajuanSumpahController',
    'admin'             => 'AdminController',
    'adminpendaftaran'  => 'AdminPendaftaranController',
    'adminsumpah'       => 'AdminSumpahController',
    'bendahara'         => 'BendaharaController',
    'ketua'             => 'KetuaController',
];

if (!isset($peta[$c])) {
    http_response_code(404);
    exit('Halaman tidak ditemukan');
}

$nama = $peta[$c];
require_once __DIR__ . "/app/controllers/$nama.php";
$controller = new $nama();

if (!preg_match('/^[a-zA-Z]+$/', $a) || !method_exists($controller, $a)) {
    http_response_code(404);
    exit('Aksi tidak ditemukan');
}

$controller->$a();