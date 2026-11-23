<h2>Pendaftaran PKPA</h2>

<?php if ($pendaftaran): ?>
    <div class="kartu">
        <p>Periode: <strong><?= e($pendaftaran['periode']) ?></strong></p>
        <p>Tanggal daftar: <?= e($pendaftaran['tanggal_daftar']) ?></p>
        <p>Status: <strong><?= e($pendaftaran['status_pendaftaran']) ?></strong></p>
        <?php if (!empty($pendaftaran['catatan'])): ?>
            <p>Catatan: <?= e($pendaftaran['catatan']) ?></p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="kartu">
        <p>Anda belum terdaftar pada periode <strong><?= e($periode) ?></strong>.</p>
        <form method="post" action="index.php?c=pendaftaran&a=daftar">
            <?= csrf_field() ?>
            <button type="submit">Daftar PKPA</button>
        </form>
    </div>
<?php endif; ?>