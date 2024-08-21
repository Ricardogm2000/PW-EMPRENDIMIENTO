<?php
session_start();
include 'header.php';

// Inicializar el carrito si no está configurado
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_GET['remove'])) {
    $removeIndex = $_GET['remove'];
    unset($_SESSION['cart'][$removeIndex]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindexar el array

    // Actualizar el contador del carrito en localStorage
    echo "<script>
        var cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
        cartCount = cartCount > 0 ? cartCount - 1 : 0;
        localStorage.setItem('cartCount', cartCount);
        window.location.href = 'cart.php'; // Recargar la página
    </script>";
}
?>

<div class="container">
    <h1 class="title">Tu Carrito de Compras</h1>
    <div class="row">
        <!-- Columna de Productos -->
        <div class="col-sm-6">
            <ul class="list-group">
                <?php 
                foreach($_SESSION['cart'] as $index => $item) {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    echo '<img src="'.$item["src"].'" class="img-thumbnail" style="width: 50px; height: 50px;">';
                    echo '<span>'.$item["title"].'</span>';
                    echo '<a href="?remove='.$index.'" class="btn btn-danger btn-sm">Eliminar</a>'; // Botón de eliminar
                    echo '</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Columna de Métodos de Pago -->
        <div class="col-sm-6">
            <h4>Métodos de Pago</h4>
            <div class="form-group">
                <label><input type="radio" name="payment_method" value="tarjeta"> Tarjetas</label><br>
                <label><input type="radio" name="payment_method" value="transferencia"> Transferencia</label><br>
                <label><input type="radio" name="payment_method" value="deuna"> DeUna</label>
            </div>
            <h4>Total: $0.00</h4> <!-- Aún no se manejan precios -->
            <button id="buy-button" class="btn btn-primary">Comprar</button>

        </div>
    </div>
</div>

<?php include 'footer.php';?>
<style> 
.list-group-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.img-thumbnail {
    width: 50px;
    height: 50px;
}

.container {
    padding-top: 20px;
}

h4 {
    margin-top: 20px;
}
</style>
<script>
document.getElementById('buy-button').addEventListener('click', function() {
    // Vaciar el localStorage
    localStorage.clear();

    // Redirigir a la página de inicio (index.php)
    window.location.href = 'index.php';
});
</script>
