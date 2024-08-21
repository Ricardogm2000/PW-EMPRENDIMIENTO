<?php
session_start();

$product = json_decode(file_get_contents('php://input'), true);

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Verificar si el producto ya está en el carrito
$exists = false;
foreach($_SESSION['cart'] as $item) {
    if($item['src'] == $product['src']) {
        $exists = true;
        break;
    }
}

// Si no existe, añadirlo al carrito
if(!$exists) {
    $_SESSION['cart'][] = $product;
}

header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Producto añadido al carrito']);
?>
