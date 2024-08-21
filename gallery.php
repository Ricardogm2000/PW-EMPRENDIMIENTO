<?php include 'header.php';?>
<div class="container">
    <h1 class="title">Audio Guías</h1>
    <div class="row gallery">
        <?php 
        $images = [
            ["src" => "images/audioguias/1.png", "title" => "MUSEO DE CERA QUITO"],
            ["src" => "images/audioguias/2.png", "title" => "MUSEO TEMPLO DEL SOL"],
            ["src" => "images/audioguias/3.png", "title" => "MUSEO CASA GUAYSAMÍN"],
            ["src" => "images/audioguias/4.png", "title" => "MUSEO DAN FRANCISCO"],
            ["src" => "images/audioguias/5.png", "title" => "MUSEO NACIONAL DEL ECUADOR"],
            ["src" => "images/audioguias/6.png", "title" => "MUSEO MANUELA SAENZ"],
            ["src" => "images/audioguias/7.png", "title" => "MUSEO CASA DE SUCRE"],
            ["src" => "images/audioguias/8.png", "title" => "MUSEO DE LA MONEDA"],
            ["src" => "images/audioguias/9.png", "title" => "MUSEO MUNICIPAL DE GUAYAQUIL"],
            ["src" => "images/audioguias/10.png", "title" => "MUSEO CIMA DE LA LIBERTAD"],
            ["src" => "images/audioguias/11.png", "title" => "MUSEO DEL BANCO CENTRAL"],
            ["src" => "images/audioguias/12.png", "title" => "MUSEO DE SITIO TULIPE"]
        ];

        foreach($images as $index => $image) {
            echo '<div class="col-sm-4 wowload fadeInUp gallery-item">';
            echo '<img src="'.$image["src"].'" class="img-responsive" alt="'.$image["title"].'">';
            echo '<div class="overlay">';
            echo '<img src="images/ojo.png" alt="Ver" class="icon view-icon" data-index="'.$index.'">';
            echo '<img src="images/carrito.png" alt="Añadir al carrito" class="icon cart-icon" data-index="'.$index.'">';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Ventana flotante -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>INFORMACION DEL AUDIO GUÍA.</p>
    </div>
</div>

<?php include 'footer.php';?>




<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById("modal");
    var viewIcons = document.querySelectorAll(".view-icon");
    var cartIcons = document.querySelectorAll(".cart-icon");
    var span = document.getElementsByClassName("close")[0];
    var cartCount = parseInt(localStorage.getItem('cartCount')) || 0; // Recupera el conteo del carrito desde localStorage

    // Actualiza el contador del carrito al cargar la página
    updateCartCount(cartCount);

    // Manejo de la ventana modal
    viewIcons.forEach(icon => {
        icon.onclick = function() {
            modal.style.display = "block";
        }
    });

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Manejo del carrito de compras
    cartIcons.forEach(icon => {
        icon.onclick = function() {
            let index = icon.getAttribute('data-index');
            let image = icon.closest('.gallery-item').querySelector('img');
            let imageSrc = image.src;
            let title = image.alt;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ src: imageSrc, title: title })
            })
            .then(response => response.text())
            .then(data => {
                cartCount += 1; // Incrementa el contador
                localStorage.setItem('cartCount', cartCount); // Guarda el nuevo conteo en localStorage
                updateCartCount(cartCount); // Actualiza el contador en el HTML
                alert("Producto añadido al carrito");
            });
        }
    });

    // Función para actualizar el contador del carrito
    function updateCartCount(newCount) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = newCount;
        }

        // Añade animación para el contador
        cartCountElement.classList.add('animate');
        setTimeout(() => {
            cartCountElement.classList.remove('animate');
        }, 1000); // Duración de la animación
    }
});
</script>

<style>
.gallery-item {
    position: relative;
    margin-bottom: 15px;
}

.gallery-item img {
    margin-bottom: 10px;
}

.gallery .col-sm-4 {
    margin-bottom: 20px; 
    padding-right: 10px; 
    padding-left: 10px; 
}

.gallery-item .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.overlay {
    z-index: 10; 
}

.gallery-item:hover .overlay {
    opacity: 1;
}

.icon {
    margin: 0 10px;
    width: 55px !important;
    height: 55px !important;
}

.modal {
    display: none;
    position: fixed;
    z-index: 20;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

