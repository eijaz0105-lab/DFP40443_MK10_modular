<?php
if (!isset($_SESSION['invois_data'])) {
    echo "<script>
            alert('Invois belum ada kerana belum ada tempahan.');
            window.location.href = 'index.php?menu=tempah';
          </script>";
    exit();
}

$invois = $_SESSION['invois_data'];
?>

<h1 class="page-title">Invois Tempahan Biskut Klasik</h1>
<div class="invoice-box">
    <div class="invoice-header">
        <div class="invoice-info">
            <strong>Kepada:</strong><br>
            <?= e($invois['nama_pelanggan']) ?>
        </div>
        <div class="invoice-info" style="text-align: right;">
            <strong>No. Invois:</strong> <?= e($invois['no_invois']) ?><br>
            <strong>Tarikh:</strong> <?= e($invois['tarikh']) ?>
        </div>
    </div>
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Saiz</th>
                <th class="text-right">Harga</th>
                <th class="text-center">Kuantiti</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($invois['items'])): ?>
                <tr>
                    <td colspan="5" class="text-center">Tiada item tempahan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($invois['items'] as $item): ?>
                    <tr>
                        <td><?= e($item['nama_produk']) ?></td>
                        <td><?= e($item['saiz']) ?></td>
                        <td class="text-right">RM <?= number_format($item['harga_seunit'], 2) ?></td>
                        <td class="text-center"><?= $item['kuantiti'] ?></td>
                        <td class="text-right">RM <?= number_format($item['jumlah_harga'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total-label-cell">Jumlah Besar</td>
                <td class="total-amount-cell">RM <?= number_format($invois['jumlah_besar'], 2) ?></td>
            </tr>
        </tfoot>
    </table>
    <div class="invoice-note">
        <p>* Sila cetak invois ini dan serahkan semasa mengambil tempahan.</p>
        <p>* Bayaran boleh dibuat secara tunai atau imbas Kod QR semasa pengambilan.</p>
    </div>
    <div class="action-buttons">
        <button onclick="window.print()" class="print-btn">Cetak Invois</button>
    </div>
</div>