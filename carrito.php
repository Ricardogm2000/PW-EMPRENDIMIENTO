<?php include 'header.php';?>

<div class="container">
    <h1 class="title">Carrito de Compras</h1>
    <div class="row">
        <!-- Columna de productos -->
        <div class="col-md-6 cart-column">
            <div class="cart-items">
                <?php
                $cart = json_decode(file_get_contents('bd/cart.json'), true);
                if (empty($cart)) {
                    echo '<p>No hay productos en el carrito.</p>';
                } else {
                    foreach ($cart as $item) {
                        echo '<div class="cart-item d-flex justify-content-between align-items-center">';
                        echo '<div>';
                        echo '<h3>' . $item['title'] . '</h3>';
                        echo '<p>ID de la Sala: ' . $item['id'] . '</p>';
                        echo '</div>';
                        echo '<i class="fa fa-trash delete-item" data-id="' . $item['id'] . '"></i>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <!-- Columna de métodos de pago -->
        <div class="col-md-6 payment-column">
            <div class="checkout">
                <h2>Detalles de Factura y Método de Pago</h2>
                <p>Subtotal: <span id="subtotal">$0.00</span></p>
                <p>IVA (12%): <span id="iva">$0.00</span></p>
                <p>Total: <span id="total">$0.00</span></p>
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

<!-- Ventana flotante para el pago con tarjeta -->
<div id="cardModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Detalles de la Tarjeta de Crédito</h2>
        <p>Por favor, ingrese los detalles de su tarjeta de crédito para completar la compra.</p>
        <form id="cardForm">
            <div class="form-group">
                <label for="cardNumber">Número de Tarjeta:</label>
                <input type="text" id="cardNumber" class="form-control" placeholder="1234 5678 9012 3456" required>
            </div>
            <div class="form-group">
                <label for="cardHolder">Nombre del Titular:</label>
                <input type="text" id="cardHolder" class="form-control" placeholder="Nombre Completo" required>
            </div>
            <div class="form-group">
                <label for="expirationDate">Fecha de Expiración:</label>
                <input type="text" id="expirationDate" class="form-control" placeholder="MM/AA" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" class="form-control" placeholder="123" required>
            </div>
            <div class="form-group">
                <input type="checkbox" id="terms" required>
                <label for="terms">He leído y acepto los <a href="#termsModal" id="termsLink">términos y condiciones</a>.</label>
            </div>
            <button type="submit" class="btn btn-primary">Pagar</button>
        </form>
    </div>
</div>

<!-- Ventana flotante para los términos y condiciones -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Términos y Condiciones</h2>
        <p>Aquí van los términos y condiciones de la tienda o servicio. Asegúrate de incluir toda la información legal necesaria.</p>
        <p>...</p>
        <p>...</p>
    </div>
</div>

<?php include 'footer.php';?>

<!-- Script para manejar el borrado de items -->
<script>
document.querySelectorAll('.delete-item').forEach(item => {
    item.addEventListener('click', function() {
        const itemId = this.getAttribute('data-id');
        
        fetch('eliminar_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: itemId })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Producto eliminado');

                // Restar el producto eliminado del contador en localStorage
                let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
                cartCount = cartCount > 0 ? cartCount - 1 : 0;
                localStorage.setItem('cartCount', cartCount);
                updateCartCount(cartCount);

                location.reload(); // Recargar la página para actualizar el carrito visualmente
            } else {
                alert('Error al eliminar el producto: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error al procesar la solicitud.');
        });
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const pricePerGuide = 5;
    const ivaRate = 0.12;

    function calculateTotals() {
        fetch('bd/cart.json')
            .then(response => response.json())
            .then(cart => {
                let subtotal = cart.reduce((sum, item) => sum + parseFloat(item.price), 0);
                let iva = subtotal * ivaRate;
                let total = subtotal + iva;

                // Actualizar los elementos del DOM
                document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
                document.getElementById('iva').textContent = '$' + iva.toFixed(2);
                document.getElementById('total').textContent = '$' + total.toFixed(2);
            });
    }

    calculateTotals();
});

    // Manejo de la ventana flotante para la tarjeta de crédito
    const cardModal = document.getElementById("cardModal");
    const cardForm = document.getElementById("cardForm");
    const closeCardModal = document.querySelector("#cardModal .close");

    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const paymentMethod = document.getElementById('paymentMethod').value;

        if (paymentMethod === 'creditCard') {
            cardModal.style.display = 'block';
        } else {
            alert('Pago con PayPal aún no implementado.');
        }
    });

    closeCardModal.onclick = function() {
        cardModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === cardModal) {
            cardModal.style.display = 'none';
        }
    }

    cardForm.addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Pago realizado con éxito.');
        cardModal.style.display = 'none';
        // Aquí podrías añadir lógica para procesar el pago
    });

</script>

<!-- Estilos para el icono -->
<style>
    .cart-item {
    display: flex;
    justify-content: flex-start; /* Alinea todos los elementos a la izquierda */
    align-items: center;
    margin-bottom: 10px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    gap: 40px; /* Ajusta el espacio entre el texto y el icono */
}

.delete-item {
    cursor: pointer;
    color: black;
    transition: color 0.3s ease, transform 0.3s ease;
    margin-left: 25px; /* Ajusta este valor según sea necesario */
}

    .delete-item:hover {
        color: red;
        transform: scale(1.2);
    }
   /* Estilos para la ventana flotante */
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0; 
    top: 0; 
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0,0,0,0.5); 
}

.modal-content {
    background-color: #fff;
    margin: 10% auto; 
    padding: 20px; 
    border: 1px solid #888;
    width: 90%; 
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.close {
    color: #888;
    float: right;
    font-size: 24px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

/* Estilos para el formulario */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-group input:focus {
    border-color: #007bff;
    outline: none;
}

.form-group input[type="checkbox"] {
    width: auto;
    margin-right: 10px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
}

/* Estilos para los términos y condiciones */
#termsModal .modal-content {
    max-width: 600px;
}

#termsModal p {
    margin-bottom: 10px;
}

#termsLink {
    color: #007bff;
    text-decoration: none;
}

#termsLink:hover {
    text-decoration: underline;
}
</style>
