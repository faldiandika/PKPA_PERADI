<div class="halaman-judul">
    <h2>Pendaftaran PKPA</h2>
</div>

<?php if ($pendaftaran): ?>
    <div class="kartu">
        <h3>Data pendaftaran</h3>
        <div class="biodata-grid">
            <div><span>Periode</span><strong><?= e($pendaftaran['periode']) ?></strong></div>
            <div><span>Tanggal daftar</span><strong><?= e($pendaftaran['tanggal_daftar']) ?></strong></div>
            <div><span>Status</span><?= badge($pendaftaran['status_pendaftaran']) ?></div>
        </div>

        <?php if (!empty($pendaftaran['catatan'])): ?>
            <div class="catatan-admin">
                <span>Catatan dari petugas</span>
                <p><?= e($pendaftaran['catatan']) ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="kartu">
        <h3>Langkah berikutnya</h3>
        <ol class="langkah">
            <li>
                <div><strong>Upload dokumen</strong><span class="ket">Ijazah dan dokumen persyaratan lainnya</span></div>
                <a class="btn btn-kecil" href="index.php?c=dokumen&a=index">Buka</a>
            </li>
            <li>
                <div><strong>Upload bukti pembayaran</strong><span class="ket">Setelah transfer biaya pendaftaran</span></div>
                <a class="btn btn-kecil btn-garis" href="index.php?c=pembayaran&a=index">Buka</a>
            </li>
        </ol>
    </div>
<?php else: ?>
    <div class="kartu ajakan">
        <h3>Belum terdaftar</h3>
        <p>Anda belum terdaftar pada periode <strong><?= e($periode) ?></strong>. Pastikan biodata sudah diisi, lalu klik tombol di bawah untuk mendaftar.</p>
        <form method="post" action="index.php?c=pendaftaran&a=daftar">
            <?= csrf_field() ?>
            <button type="submit">Daftar PKPA</button>
        </form>
    </div>
<?php endif; ?>