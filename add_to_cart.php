<?php
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$title = $data['title'];
$price = $data['price']; // Precio recibido

$cartFile = 'bd/cart.json';
$cart = json_decode(file_get_contents($cartFile), true);

// Agregar nuevo ítem al carrito
$cart[] = array('id' => $id, 'title' => $title, 'price' => $price);
file_put_contents($cartFile, json_encode($cart));

// Contar el número de productos en el carrito
$cartCount = count($cart);

// Enviar la respuesta
echo json_encode(array('success' => true, 'cartCount' => $cartCount));
?>
