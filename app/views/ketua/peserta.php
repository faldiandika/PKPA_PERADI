<style>
@page {
    size: A4 portrait;
    margin: 1.5cm;
}

@media print {
    nav, header, footer, .no-print {
        display: none !important;
    }

    body {
        margin: 0;
        background: #fff;
    }

    .kartu, .tabel {
        box-shadow: none !important;
    }

    /* Header tabel muncul kembali di setiap halaman */
    .tabel-daftar thead {
        display: table-header-group;
    }

    .tabel-daftar tbody {
        display: table-row-group;
    }

    /* Baris peserta tidak terpotong */
    .tabel-daftar tr {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    /* Ringkasan boleh berpindah halaman */
    .ringkas {
        break-inside: avoid;
        page-break-inside: avoid;
    }

    /* Tanda tangan tetap utuh di bagian akhir */
    .ttd-cetak {
        break-inside: avoid;
        page-break-inside: avoid;
        margin-top: 30px;
    }

    .badge {
        border: 1px solid #94a3b8;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}
</style>
<?php
$rekap = [];
$tot = ['total' => 0, 'diterima' => 0, 'lunas' => 0, 'rp' => 0];
$statusDaftar = [];
foreach ($daftar as $r) {
    $k = $r['periode'] ?: '(tanpa periode)';
    $rekap[$k] ??= ['total' => 0, 'diterima' => 0, 'lunas' => 0, 'rp' => 0];
    $rekap[$k]['total']++; $tot['total']++;
    if ($r['status_pendaftaran'] === 'diterima') { $rekap[$k]['diterima']++; $tot['diterima']++; }
    if ($r['status_bayar'] === 'diverifikasi') {
        $rekap[$k]['lunas']++; $tot['lunas']++;
        $rekap[$k]['rp'] += (float)$r['total_bayar'];
        $tot['rp'] += (float)$r['total_bayar'];
    }
    $statusDaftar[$r['status_pendaftaran']] = true;
}
?>
<div id="laporan" data-mode="pendaftar">

<div class="kop-cetak">
    <strong>DPC PERADI KOTA PALU</strong>
    <span id="kopJudul">Laporan Pendaftar PKPA</span>
</div>

<div class="halaman-judul">
    <div>
        <h2 id="judulLaporan">Daftar Pendaftar PKPA</h2>
        <p class="laporan-ket">DPC PERADI Kota Palu, dicetak <?= date('d-m-Y') ?></p>
    </div>
    <p class="no-print" style="margin:0"><button type="button" onclick="window.print()">Cetak laporan</button></p>
</div>

<div class="ringkas-kartu no-print">
    <div class="rk"><span>Total pendaftar</span><strong><?= $tot['total'] ?></strong></div>
    <div class="rk"><span>Diterima</span><strong><?= $tot['diterima'] ?></strong></div>
    <div class="rk"><span>Pembayaran terverifikasi</span><strong><?= $tot['lunas'] ?></strong></div>
    <div class="rk rk-utama"><span>Total diterima</span><strong>Rp <?= number_format($tot['rp'], 0, ',', '.') ?></strong></div>
</div>

<div class="filter-bar no-print">
    <label for="jenisLaporan" style="margin:0;font-weight:600">Jenis laporan</label>
    <select id="jenisLaporan">
        <option value="pendaftar">Daftar pendaftar</option>
        <option value="lolos">Peserta memenuhi persyaratan</option>
        <option value="bayar">Rekapitulasi pembayaran</option>
    </select>
</div>

<h3 class="sub-judul">Ringkasan per periode</h3>
<table class="tabel ringkas">
    <tr>
        <th>Periode</th>
        <th class="s-daftar">Pendaftar</th>
        <th class="s-lolos">Memenuhi persyaratan</th>
        <th class="s-bayar">Pembayaran terverifikasi</th>
        <th class="s-bayar">Total diterima</th>
    </tr>
    <?php foreach ($rekap as $periode => $n): ?>
    <tr>
        <td><strong><?= e($periode) ?></strong></td>
        <td class="s-daftar"><?= $n['total'] ?></td>
        <td class="s-lolos"><?= $n['diterima'] ?></td>
        <td class="s-bayar"><?= $n['lunas'] ?></td>
        <td class="s-bayar">Rp <?= number_format($n['rp'], 0, ',', '.') ?></td>
    </tr>
    <?php endforeach; ?>
    <?php if (!$rekap): ?><tr><td colspan="5" class="kosong-baris">Belum ada data.</td></tr><?php endif; ?>
</table>

<h3 class="sub-judul">Daftar</h3>
<p class="filter-cetak" id="ketFilter"></p>

<div class="filter-bar no-print">
    <input type="text" id="cariPeserta" placeholder="Cari nama atau perguruan tinggi">
    <select id="filterStatus">
        <option value="">Semua status pendaftaran</option>
        <?php foreach (array_keys($statusDaftar) as $s): ?>
            <option value="<?= e($s) ?>"><?= e($s) ?></option>
        <?php endforeach; ?>
    </select>
</div>

<table class="tabel tabel-daftar" id="tabelPeserta">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th class="k-pt">Perguruan tinggi</th>
            <th>Periode</th>
            <th class="k-daftar">Pendaftaran</th>
            <th class="k-bayar">Pembayaran</th>
            <th class="k-bayar kol-rp">Jumlah bayar</th>
        </tr>
    </thead>

    <tbody>
        <?php $no = 1; foreach ($daftar as $r): ?>
        <tr class="baris-peserta"
            data-cari="<?= e(strtolower($r['nama_lengkap'] . ' ' . $r['perguruan_tinggi'])) ?>"
            data-status="<?= e($r['status_pendaftaran']) ?>">

            <td class="no-kol"><?= $no++ ?></td>
            <td><strong><?= e($r['nama_lengkap']) ?></strong></td>
            <td class="k-pt"><?= e($r['perguruan_tinggi']) ?></td>
            <td><?= e($r['periode'] ?? '-') ?></td>
            <td class="k-daftar"><?= badge($r['status_pendaftaran']) ?></td>
            <td class="k-bayar"><?= badge($r['status_bayar'] ?? 'belum bayar') ?></td>
            <td class="k-bayar kol-rp">
                <?= ($r['status_bayar'] ?? '') === 'diverifikasi'
                    ? 'Rp ' . number_format((float)$r['total_bayar'], 0, ',', '.')
                    : '-' ?>
            </td>
        </tr>
        <?php endforeach; ?>

        <?php if (!$daftar): ?>
        <tr>
            <td colspan="7" class="kosong-baris">Belum ada peserta.</td>
        </tr>
        <?php endif; ?>

        <tr id="kosongCari" style="display:none">
            <td colspan="7" class="kosong-baris">Tidak ada data yang cocok.</td>
        </tr>
    </tbody>
</table>

<div class="ttd-cetak">
    <p>Palu, <?= date('d-m-Y') ?></p>
    <p>Ketua DPC PERADI Kota Palu</p>
    <div class="ttd-ruang"></div>
    <p>(____________________)</p>
</div>

</div>

<script>
(function () {
    var wrap = document.getElementById('laporan');
    var jenis = document.getElementById('jenisLaporan');
    var q = document.getElementById('cariPeserta');
    var s = document.getElementById('filterStatus');
    var ket = document.getElementById('ketFilter');
    var judul = document.getElementById('judulLaporan');
    var kop = document.getElementById('kopJudul');
    var baris = document.querySelectorAll('.baris-peserta');
    var kosong = document.getElementById('kosongCari');
    var NAMA = {
        pendaftar: 'Daftar Pendaftar PKPA',
        lolos: 'Daftar Peserta yang Memenuhi Persyaratan',
        bayar: 'Rekapitulasi Pembayaran PKPA'
    };
    function saring() {
        var mode = jenis.value;
        var kata = q.value.trim().toLowerCase();
        var st = (mode === 'pendaftar') ? s.value : '';
        var tampil = 0;
        wrap.dataset.mode = mode;
        judul.textContent = NAMA[mode];
        kop.textContent = NAMA[mode];
        s.style.display = (mode === 'pendaftar') ? '' : 'none';
        baris.forEach(function (b) {
            var ok = b.dataset.cari.indexOf(kata) !== -1;
            if (mode === 'lolos') ok = ok && b.dataset.status === 'diterima';
            if (st !== '') ok = ok && b.dataset.status === st;
            b.style.display = ok ? '' : 'none';
            if (ok) { tampil++; b.querySelector('.no-kol').textContent = tampil; }
        });
        kosong.style.display = (baris.length && !tampil) ? '' : 'none';
        var info = [];
        if (st !== '') info.push('status pendaftaran: ' + st);
        if (kata !== '') info.push('kata kunci: "' + q.value.trim() + '"');
        ket.textContent = info.length ? 'Filter: ' + info.join(', ') + ' (' + tampil + ' data)' : '';
    }
    jenis.addEventListener('change', saring);
    q.addEventListener('input', saring);
    s.addEventListener('change', saring);
    saring();
})();
</script>