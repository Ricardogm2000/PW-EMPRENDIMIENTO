<?php
// Establecer el encabezado para respuestas JSON
header('Content-Type: application/json');

// Habilitar la visualización de errores para depuración (solo durante el desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Leer los datos crudos de la solicitud
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    // Verificar si la decodificación de JSON fue exitosa
    if ($data === null) {
        throw new Exception('JSON inválido.');
    }

    // Verificar si el ID está presente
    if (!isset($data['id'])) {
        throw new Exception('ID no proporcionado.');
    }

    $id = $data['id'];

    // Ruta al archivo JSON del carrito
    $cartFile = 'bd/cart.json';

    // Verificar si el archivo del carrito existe
    if (!file_exists($cartFile)) {
        throw new Exception('Archivo del carrito no encontrado.');
    }

    // Leer y decodificar el contenido del carrito
    $cart = json_decode(file_get_contents($cartFile), true);
    if ($cart === null) {
        throw new Exception('Contenido JSON del carrito inválido.');
    }

    // Filtrar el carrito para eliminar el producto con el ID especificado
    $updatedCart = array_filter($cart, function($item) use ($id) {
        return $item['id'] !== $id;
    });

    // Reindexar el array para evitar claves vacías
    $updatedCart = array_values($updatedCart);

    // Guardar el carrito actualizado en el archivo JSON
    if (file_put_contents($cartFile, json_encode($updatedCart, JSON_PRETTY_PRINT)) === false) {
        throw new Exception('No se pudo escribir en el archivo del carrito.');
    }

    // Devolver una respuesta de éxito
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Devolver una respuesta de error en formato JSON
    http_response_code(400); // Código de estado HTTP 400 (Bad Request)
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
