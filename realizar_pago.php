<?php
$data = json_decode(file_get_contents('php://input'), true);
$paymentMethod = $data['paymentMethod'];

// Leer el archivo JSON existente
$cart = json_decode(file_get_contents('bd/cart.json'), true);
$purchases = json_decode(file_get_contents('bd/purchases.json'), true);

// Guardar la compra en el archivo JSON
foreach ($cart as $item) {
    $purchases[] = [
        'id' => $item['id'],
        'title' => $item['title'],
        'paymentMethod' => $paymentMethod
    ];
}
file_put_contents('bd/purchases.json', json_encode($purchases));

// Vaciar el carrito
file_put_contents('bd/cart.json', json_encode([]));

// Devolver una respuesta
echo json_encode(['success' => true]);
?>