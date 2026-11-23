
<div class="dash-sapa">
    <div>
        <span class="dash-label">Beranda Ketua</span>
        <h2>Selamat datang, <?= e($user['nama'] ?? '') ?></h2>
        <p>Pantau rekap pendaftaran, pembayaran, dan pemberkasan sumpah. Laporan lengkap dapat dilihat melalui menu Daftar Peserta.</p>
    </div>
</div>

<div class="dash-grid dash-ringkas">
    <div class="kartu stat">
        <h3>Total peserta</h3>
        <div class="stat-total">
            <strong><?= (int)$jmlPeserta ?></strong>
            <span>peserta terdaftar</span>
        </div>
    </div>

    <div class="kartu stat">
        <h3>Jadwal sumpah</h3>
        <div class="stat-total">
            <strong><?= (int)$jmlJadwal ?></strong>
            <span>sudah terjadwal</span>
        </div>
    </div>
</div>

<?php
$blok = [
    'Status pendaftaran' => $pendaftaran,
    'Status pembayaran' => $pembayaran,
    'Status pemberkasan sumpah' => $sumpah
];
?>

<div class="dash-grid">
<?php foreach ($blok as $judul => $baris):
    $total = 0;
    foreach ($baris as $r) {
        $total += (int)$r['n'];
    }
?>
    <div class="kartu stat">
        <h3><?= e($judul) ?></h3>
        <div class="stat-total">
            <strong><?= $total ?></strong>
            <span>total</span>
        </div>

        <?php foreach ($baris as $r): ?>
            <div class="stat-baris">
                <span class="badge <?= e($r['s']) ?>"><?= e($r['s']) ?></span>
                <strong><?= (int)$r['n'] ?></strong>
            </div>
        <?php endforeach; ?>

        <?php if (!$baris): ?>
            <p class="kosong">Belum ada data.</p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
</div>

<p style="margin-top:18px">
    <a class="btn" href="index.php?c=ketua&a=peserta">Lihat Daftar Peserta</a>
</p>
