<style>
@page { margin: 0; }
@media print {
    nav, header, footer, .no-print { display: none !important; }
    body { margin: 1.5cm; }
}
</style>
<?php
$rekap = [];
foreach ($daftar as $r) {
    $k = $r['periode'] ?: '(tanpa periode)';
    $rekap[$k] ??= ['total' => 0, 'diterima' => 0, 'lunas' => 0, 'rp' => 0];
    $rekap[$k]['total']++;
    if ($r['status_pendaftaran'] === 'diterima') $rekap[$k]['diterima']++;
    if ($r['status_bayar'] === 'diverifikasi') {
        $rekap[$k]['lunas']++;
        $rekap[$k]['rp'] += (float)$r['total_bayar'];
    }
}
?>
<h2>Daftar Peserta</h2>
<p>DPC PERADI Kota Palu, dicetak <?= date('d-m-Y') ?></p>
<p class="no-print"><button type="button" onclick="window.print()">Cetak</button></p>

<h3>Ringkasan per periode</h3>
<table class="tabel">
    <tr><th>Periode</th><th>Pendaftar</th><th>Diterima</th><th>Pembayaran terverifikasi</th><th>Total diterima</th></tr>
    <?php foreach ($rekap as $periode => $n): ?>
    <tr>
        <td><?= e($periode) ?></td>
        <td><?= $n['total'] ?></td>
        <td><?= $n['diterima'] ?></td>
        <td><?= $n['lunas'] ?></td>
        <td>Rp <?= number_format($n['rp'], 0, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$rekap): ?><tr><td colspan="5">Belum ada data.</td></tr><?php endif; ?>
</table>

<h3>Daftar</h3>
<table class="tabel">
    <tr><th>No</th><th>Nama</th><th>Perguruan tinggi</th><th>Periode</th><th>Pendaftaran</th><th>Pembayaran</th></tr>
    <?php $no = 1; foreach ($daftar as $r): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= e($r['nama_lengkap']) ?></td>
        <td><?= e($r['perguruan_tinggi']) ?></td>
        <td><?= e($r['periode'] ?? '-') ?></td>
        <td><?= badge($r['status_pendaftaran']) ?></td>
        <td><?= badge($r['status_bayar'] ?? 'belum bayar') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$daftar): ?><tr><td colspan="6">Belum ada peserta.</td></tr><?php endif; ?>
</table>