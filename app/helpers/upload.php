<?php
function uploadFile(array $f, string $folder, array $ekstensi, int $maxByte = 2097152): array {
    $err = $f['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($err === UPLOAD_ERR_NO_FILE) {
        return ['ok' => false, 'kosong' => true, 'pesan' => 'File belum dipilih.'];
    }
    if ($err !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'kosong' => false, 'pesan' => 'Upload gagal (kode ' . $err . ').'];
    }
    if ($f['size'] > $maxByte) {
        return ['ok' => false, 'kosong' => false, 'pesan' => 'Ukuran file maksimal ' . round($maxByte / 1048576) . ' MB.'];
    }
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $ekstensi, true)) {
        return ['ok' => false, 'kosong' => false, 'pesan' => 'Format file harus: ' . implode(', ', $ekstensi) . '.'];
    }
    $mimeOk = [
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
        'pdf'  => ['application/pdf'],
    ];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    if (!in_array($mime, $mimeOk[$ext] ?? [], true)) {
        return ['ok' => false, 'kosong' => false, 'pesan' => 'Isi file tidak sesuai dengan formatnya.'];
    }
    $dir = __DIR__ . '/../../public/uploads/' . $folder;
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $nama = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $nama)) {
        return ['ok' => false, 'kosong' => false, 'pesan' => 'File gagal disimpan di server.'];
    }
    return ['ok' => true, 'kosong' => false, 'nama' => $nama];
}

function hapusFile(string $folder, string $nama): void {
    $nama = basename($nama);
    if ($nama === '') {
        return;
    }
    $path = __DIR__ . '/../../public/uploads/' . $folder . '/' . $nama;
    if (is_file($path)) {
        unlink($path);
    }
}