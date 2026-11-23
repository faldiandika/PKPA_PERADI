<div class="dash-sapa">
    <div>
        <span class="dash-label">Beranda Peserta</span>
        <h2>Selamat datang, <?= e($user['nama'] ?? '') ?></h2>
        <p>Ikuti langkah di bawah untuk menyelesaikan pendaftaran PKPA. Status terbaru muncul di bagian pemberitahuan.</p>
    </div>
    <?php if (!empty($peserta['pas_foto'])): ?>
        <img class="pas-foto" src="public/uploads/pas_foto/<?= e($peserta['pas_foto']) ?>" alt="Pas foto" width="96">
    <?php endif; ?>
</div>

<div class="dash-grid">
    <div class="kartu">
        <h3>Langkah pendaftaran</h3>
        <ol class="langkah">
            <li>
                <div>
                    <strong>Biodata</strong>
                    <span class="ket">
                        <?= $peserta ? 'Sudah diisi' : 'Belum diisi' ?>
                    </span>
                </div>
                <a class="btn btn-kecil <?= $peserta ? 'btn-garis' : '' ?>" href="index.php?c=peserta&a=biodata"><?= $peserta ? 'Ubah' : 'Isi sekarang' ?></a>
            </li>
            <li>
                <div><strong>Pendaftaran PKPA</strong><span class="ket">Daftar ke periode yang dibuka</span></div>
                <a class="btn btn-kecil btn-garis" href="index.php?c=pendaftaran&a=index">Buka</a>
            </li>
            <li>
                <div><strong>Upload dokumen</strong><span class="ket">Ijazah dan dokumen persyaratan</span></div>
                <a class="btn btn-kecil btn-garis" href="index.php?c=dokumen&a=index">Buka</a>
            </li>
            <li>
                <div><strong>Upload bukti pembayaran</strong><span class="ket">Setelah transfer biaya pendaftaran</span></div>
                <a class="btn btn-kecil btn-garis" href="index.php?c=pembayaran&a=index">Buka</a>
            </li>
            <li>
                <div><strong>Pengajuan sumpah</strong><span class="ket">Tersedia setelah tahapan sebelumnya</span></div>
                <a class="btn btn-kecil btn-garis" href="index.php?c=pengajuansumpah&a=index">Buka</a>
            </li>
        </ol>
    </div>

    <div class="kartu">
        <h3>Pemberitahuan</h3>
        <?php foreach ($notif as [$tipe, $pesan]): ?>
            <div class="flash <?= e($tipe) ?>"><?= e($pesan) ?></div>
        <?php endforeach; ?>
        <?php if (!$notif): ?><p class="kosong">Belum ada pemberitahuan.</p><?php endif; ?>
    </div>
</div>