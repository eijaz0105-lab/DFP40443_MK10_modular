<?php
session_start();

require_once 'data/products.php';
require_once 'processes/functions.php';

$menu = getMenu();
$data = getProducts($productsData);

if ($menu === 'utama') {
    $pageTitle = 'Biskut Klasik - Utama';
    include 'includes/header.php';
    include 'includes/nav.php';
    ?>
        <h1 class="page-title">Selamat Datang</h1>
        <div class="gallery-row">
            <?php foreach ($data as $produk): ?>
                <img src="gambar/<?= e($produk['gambar']) ?>" alt="<?= e($produk['nama']) ?>" class="gallery-thumb">
            <?php endforeach; ?>
        </div>
        <div class="instructions-section">
            <h3>Cara Membuat Tempahan</h3>
            <p>
                Selamat datang ke Biskut Klasik! Untuk membuat tempahan, sila ikuti langkah-langkah mudah ini. Mula-mula, klik pada menu <strong>Tempah</strong> di bahagian atas. Isikan kuantiti biskut yang anda inginkan dan masukkan nama anda, kemudian klik butang <strong>Teruskan</strong>. Invois akan dipaparkan secara automatik. Sila klik butang <strong>Cetak</strong> untuk mencetak invois tersebut. Invois ini perlu diserahkan kepada kami semasa membuat tempahan. Bayaran boleh dibuat secara tunai atau imbasan Kod QR semasa hari pengambilan tempahan. Terima kasih!
            </p>
        </div>
    <?php
    include 'includes/footer.php';

} elseif ($menu === 'tempah') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $namaPelanggan = isset($_POST['nama_pelanggan']) ? htmlspecialchars(trim($_POST['nama_pelanggan'])) : "Pelanggan";
        $tempahanInput = isset($_POST['tempahan']) ? $_POST['tempahan'] : [];

        $orderResult = processOrder($data, $tempahanInput);
        $itemTempahan = $orderResult['items'];
        $jumlahBesar = $orderResult['jumlah_besar'];

        if ($jumlahBesar == 0) {
            echo "<script>alert('Sila pilih sekurang-kurangnya satu jenis biskut sebelum meneruskan tempahan.'); window.location.href='index.php?menu=tempah';</script>";
            exit();
        }

        $_SESSION['invois_data'] = generateInvoice($namaPelanggan, $itemTempahan, $jumlahBesar);
        $invois = $_SESSION['invois_data'];

        $pageTitle = 'Biskut Klasik - Invois Tempahan';
        $menu = 'invois';
        include 'includes/header.php';
        include 'includes/nav.php';
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
        <?php
        include 'includes/footer.php';
        exit();
    }

    $pageTitle = 'Biskut Klasik - Borang Tempahan';
    include 'includes/header.php';
    include 'includes/nav.php';
    ?>
        <h1 class="page-title">Borang Tempahan</h1>
        <form action="" method="POST">
            <div class="product-grid">
                <?php foreach ($data as $produk): ?>
                    <div class="product-card">
                        <img src="gambar/<?= e($produk['gambar']) ?>" alt="<?= e($produk['nama']) ?>" class="product-image">
                        <h3 class="product-name"><?= e($produk['nama']) ?></h3>
                        <?php foreach ($produk['harga'] as $saizKey => $harga): ?>
                            <div class="product-option">
                                <label for="produk_<?= $produk['id'] ?>_<?= $saizKey ?>" class="option-label">
                                    <span class="option-name"><?= e(ucwords(str_replace('_', ' ', $saizKey))) ?></span>
                                    <span class="option-price">RM <?= number_format($harga, 2) ?></span>
                                </label>
                                <input type="number" id="produk_<?= $produk['id'] ?>_<?= $saizKey ?>" name="tempahan[<?= $produk['id'] ?>][<?= $saizKey ?>]" min="0" value="0" data-price="<?= $harga ?>" class="qty-input">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="checkout-section">
                <div class="total-display">
                    <span class="total-label">Jumlah Harga:</span>
                    <span class="total-amount" id="total-price">RM 0.00</span>
                </div>
                <div class="form-group">
                    <label for="nama" class="input-label">Nama Penuh Anda:</label>
                    <input type="text" id="nama" name="nama_pelanggan" placeholder="Contoh: Ali Bin Abu" required class="checkout-input">
                </div>
                <button type="submit" class="checkout-button">Teruskan</button>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const quantityInputs = document.querySelectorAll('.qty-input');
                const totalPriceEl = document.getElementById('total-price');
                const form = document.querySelector('form');

                function calculateTotal() {
                    let total = 0;
                    quantityInputs.forEach(input => {
                        let quantity = parseInt(input.value, 10);
                        if (isNaN(quantity) || quantity < 0) { quantity = 0; }
                        const price = parseFloat(input.dataset.price) || 0;
                        if (quantity > 0) { total += quantity * price; }
                    });
                    const formatter = new Intl.NumberFormat('ms-MY', { style: 'currency', currency: 'MYR' });
                    totalPriceEl.textContent = formatter.format(total);
                }

                quantityInputs.forEach(input => {
                    input.addEventListener('input', calculateTotal);
                    input.addEventListener('blur', function () {
                        const value = parseFloat(this.value);
                        if (!isNaN(value) && value > 0) {
                            this.value = Math.round(value);
                        } else {
                            this.value = 0;
                        }
                        calculateTotal();
                    });
                });

                if (form) {
                    form.addEventListener('submit', function(e) {
                        let total = 0;
                        quantityInputs.forEach(input => {
                            let quantity = parseInt(input.value, 10);
                            const price = parseFloat(input.dataset.price) || 0;
                            if (!isNaN(quantity) && quantity > 0) { total += quantity * price; }
                        });

                        if (total === 0) {
                            e.preventDefault();
                            alert('Sila pilih sekurang-kurangnya satu jenis biskut sebelum meneruskan tempahan.');
                        }
                    });
                }
            });
        </script>
    <?php
    include 'includes/footer.php';

} elseif ($menu === 'invois') {
    if (!isset($_SESSION['invois_data'])) {
        echo "<script>
                alert('Invois belum ada kerana belum ada tempahan.');
                window.location.href = 'index.php?menu=tempah';
              </script>";
        exit();
    }

    $invois = $_SESSION['invois_data'];

    $pageTitle = 'Biskut Klasik - Invois Tempahan';
    include 'includes/header.php';
    include 'includes/nav.php';
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
    <?php
    include 'includes/footer.php';

} else {
    $pageTitle = 'Menu tidak ditemukan';
    include 'includes/header.php';
    ?>
        <div class="container" style="text-align: center; padding-top: 50px;">
            <h1>Menu tidak ditemukan</h1>
            <p>Maaf, halaman yang anda cari tidak wujud.</p>
            <a href="index.php?menu=utama">Kembali ke Utama</a>
        </div>
    <?php
    include 'includes/footer.php';
}