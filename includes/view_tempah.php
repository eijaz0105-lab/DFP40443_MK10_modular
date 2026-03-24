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
                        <input
                            type="number"
                            id="produk_<?= $produk['id'] ?>_<?= $saizKey ?>"
                            name="tempahan[<?= $produk['id'] ?>][<?= $saizKey ?>]"
                            min="0"
                            value="0"
                            data-price="<?= $harga ?>"
                            class="qty-input"
                        >
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