<?php include 'header.php';?>

<div class="container">
    <h1 class="title">Carrito de Compras</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="cart-items">
                <?php
                $cart = json_decode(file_get_contents('bd/cart.json'), true);
                if (empty($cart)) {
                    echo '<p>No hay productos en el carrito.</p>';
                } else {
                    foreach ($cart as $item) {
                        echo '<div class="cart-item">';
                        echo '<h3>' . $item['title'] . '</h3>';
                        echo '<p>ID de la Sala: ' . $item['id'] . '</p>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
            <div class="checkout">
                <h2>Detalles de Factura y Método de Pago</h2>
                <form id="checkoutForm">
                    <div class="form-group">
                        <label for="paymentMethod">Método de Pago:</label>
                        <select id="paymentMethod" class="form-control">
                            <option value="creditCard">Tarjeta de Crédito</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Realizar Pago</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(event) {
    event.preventDefault();
    fetch('realizar_pago.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ paymentMethod: document.getElementById('paymentMethod').value })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pago realizado con éxito');
            history.back(); // Volver a la página anterior y refrescarla
        } else {
            alert('Error al realizar el pago');
        }
    });
});
</script>