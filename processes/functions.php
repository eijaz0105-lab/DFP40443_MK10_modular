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

function getActiveClass($currentMenu, $menuName)
{
    return $currentMenu === $menuName ? 'active' : '';
}

function e($value)
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}