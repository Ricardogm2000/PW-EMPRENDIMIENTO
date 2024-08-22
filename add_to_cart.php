<?php
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$title = $data['title'];

// Leer el archivo JSON existente
$cart = json_decode(file_get_contents('bd/cart.json'), true);

// Verificar si la sala ya está en el carrito
foreach ($cart as $item) {
    if ($item['id'] == $id) {
        echo json_encode(['success' => false, 'message' => 'La sala ya está en el carrito']);
        exit;
    }
}

// Agregar la nueva sala al carrito
$cart[] = ['id' => $id, 'title' => $title];

// Guardar el archivo JSON actualizado
file_put_contents('bd/cart.json', json_encode($cart));

// Devolver una respuesta
echo json_encode(['success' => true, 'cartCount' => count($cart)]);
?>