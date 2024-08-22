<?php
$purchases = json_decode(file_get_contents('bd/purchases.json'), true);
echo json_encode(['purchases' => $purchases]);
?>