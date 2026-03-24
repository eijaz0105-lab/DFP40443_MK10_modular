<?php
session_start();

require_once 'data/products.php';
require_once 'processes/functions.php';

$menu = getMenu();
$data = getProducts($productsData);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $menu === 'tempah') {
    handleOrderSubmission($data);
}

$pageTitle = getPageTitle($menu);

include 'includes/header.php';
include 'includes/nav.php';

if ($menu === 'utama') {
    include 'includes/view_utama.php';
} elseif ($menu === 'tempah') {
    include 'includes/view_tempah.php';
} elseif ($menu === 'invois') {
    include 'includes/view_invois.php';
} else {
    include 'includes/view_error.php';
}

include 'includes/footer.php';