<?php

function getMenu()
{
    return $_GET['menu'] ?? 'utama';
}

function getProducts($productsData)
{
    return $productsData;
}

function findProductById($products, $productId)
{
    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product;
        }
    }

    return null;
}

function processOrder($products, $tempahanInput)
{
    $itemTempahan = [];
    $jumlahBesar = 0;

    foreach ($tempahanInput as $produkId => $saizList) {
        $produkDetail = findProductById($products, $produkId);

        if ($produkDetail) {
            foreach ($saizList as $saiz => $kuantiti) {
                $kuantiti = (int) $kuantiti;

                if ($kuantiti > 0 && isset($produkDetail['harga'][$saiz])) {
                    $hargaSeunit = $produkDetail['harga'][$saiz];
                    $jumlahHarga = $kuantiti * $hargaSeunit;

                    $itemTempahan[] = [
                        'nama_produk' => $produkDetail['nama'],
                        'saiz' => ucwords(str_replace('_', ' ', $saiz)),
                        'harga_seunit' => $hargaSeunit,
                        'kuantiti' => $kuantiti,
                        'jumlah_harga' => $jumlahHarga
                    ];

                    $jumlahBesar += $jumlahHarga;
                }
            }
        }
    }

    return [
        'items' => $itemTempahan,
        'jumlah_besar' => $jumlahBesar
    ];
}

function generateInvoice($namaPelanggan, $items, $jumlahBesar)
{
    return [
        'no_invois' => 'INV-' . rand(10000, 99999),
        'nama_pelanggan' => $namaPelanggan,
        'tarikh' => date("d/m/Y"),
        'items' => $items,
        'jumlah_besar' => $jumlahBesar
    ];
}

function handleOrderSubmission($data)
{
    $namaPelanggan = isset($_POST['nama_pelanggan'])
        ? htmlspecialchars(trim($_POST['nama_pelanggan']), ENT_QUOTES, 'UTF-8')
        : 'Pelanggan';

    $tempahanInput = isset($_POST['tempahan']) ? $_POST['tempahan'] : [];

    $orderResult = processOrder($data, $tempahanInput);
    $itemTempahan = $orderResult['items'];
    $jumlahBesar = $orderResult['jumlah_besar'];

    if ($jumlahBesar == 0) {
        echo "<script>alert('Sila pilih sekurang-kurangnya satu jenis biskut sebelum meneruskan tempahan.'); window.location.href='index.php?menu=tempah';</script>";
        exit();
    }

    $_SESSION['invois_data'] = generateInvoice($namaPelanggan, $itemTempahan, $jumlahBesar);

    header('Location: index.php?menu=invois');
    exit();
}

function getPageTitle($menu)
{
    if ($menu === 'utama') {
        return 'Biskut Klasik - Utama';
    }

    if ($menu === 'tempah') {
        return 'Biskut Klasik - Borang Tempahan';
    }

    if ($menu === 'invois') {
        return 'Biskut Klasik - Invois Tempahan';
    }

    return 'Menu tidak ditemukan';
}

function getActiveClass($currentMenu, $menuName)
{
    return $currentMenu === $menuName ? 'active' : '';
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}