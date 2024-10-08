<?php include 'header.php';?>

<div class="container">
    <h1 class="title"><?php echo $museumTitle; ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="row gallery">
                <?php 
                    $pricePerGuide = 5; // Precio de cada audioguía
                    foreach($rooms as $room) {
                        echo '<div class="col-sm-6 col-md-3 wowload fadeInUp gallery-item">';
                        echo '<div class="gallery-image-container">';
                        echo '<img src="'.$room["src"].'" class="img-responsive" alt="'.$room["title"].'">';
                        echo '<div class="overlay">';
                        echo '<div class="overlay-content">';
                        echo '<div class="language-options">';
                        echo '<a href="#" class="icon buy-icon" data-id="'.$room["id"].'" data-title="'.$room["title"].'" data-price="'.$pricePerGuide.'"><i class="fa fa-shopping-cart"></i> Comprar</a>';
                        echo '<a href="#" class="icon play-icon" data-audio="'.$room["audio_es"].'" data-id="'.$room["id"].'" style="display:none;"><i class="fa fa-play"></i> Español</a>';
                        echo '<a href="#" class="icon play-icon" data-audio="'.$room["audio_ru"].'" data-id="'.$room["id"].'" style="display:none;"><i class="fa fa-play"></i> Русский</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="gallery-title">'.$room["title"].'</div>';
                        echo '<p>'.$room["info"].'</p>';
                        echo '<p>Precio: $' . $pricePerGuide . '</p>'; // Mostrar el precio
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Ventana flotante para reproducir audio -->
<div id="audioModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <audio controls id="audioPlayer">
            <source id="audioSource" src="" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</div>

<?php include 'footer.php';?>

<!-- Estilos personalizados -->
<style>
    /* Estilo para el modal */
    #audioModal {
        display: none; /* Oculto por defecto */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
    }

    /* Estilo para el contenido del modal */
    .modal-content {
        background-color: #73726c;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px; /* Máximo ancho */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Sombra */
        border-radius: 8px; /* Bordes redondeados */
    }

    /* Estilo para el botón de cerrar */
    .close {
        color: #f8f8f8;
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

    /* Estilo para el reproductor de audio */
    #audioPlayer {
        width: 100%;
        margin-top: 20px;
        outline: none;
        background-color: #73726c; /* Color de fondo del reproductor de audio */
    }

    /* Personalización de los controles del reproductor */
    #audioPlayer::-webkit-media-controls-panel {
        background-color: #bfa145; /* Fondo de los controles */
    }

    #audioPlayer::-webkit-media-controls-play-button,
    #audioPlayer::-webkit-media-controls-volume-slider {
        filter: invert(0); /* Invertir colores para mayor contraste */
    }

    /* Estilo adicional para dispositivos móviles */
    @media screen and (max-width: 600px) {
        .modal-content {
            width: 90%;
        }
    }
</style>

<!-- Script para manejar el carrito y calcular el subtotal e IVA -->
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById("audioModal");
    var audioPlayer = document.getElementById("audioPlayer");
    var audioSource = document.getElementById("audioSource");
    var playIcons = document.querySelectorAll(".play-icon");
    var buyIcons = document.querySelectorAll(".buy-icon");
    var span = document.getElementsByClassName("close")[0];
    var cartCount = document.getElementById("cart-count");
    var subtotalElement = document.getElementById("subtotal");
    var ivaElement = document.getElementById("iva");
    var totalElement = document.getElementById("total");

    // Obtener el estado de las compras desde el archivo JSON
    function loadPurchases() {
        fetch('get_purchases.php')
            .then(response => response.json())
            .then(data => {
                // Resetear los íconos antes de actualizar
                playIcons.forEach(icon => {
                    icon.style.display = 'none';
                });
                buyIcons.forEach(icon => {
                    icon.style.display = 'block';
                });

                data.purchases.forEach(purchase => {
                    document.querySelectorAll('.play-icon[data-id="'+purchase.id+'"]').forEach(playIcon => {
                        playIcon.style.display = 'block';
                    });
                    document.querySelectorAll('.buy-icon[data-id="'+purchase.id+'"]').forEach(buyIcon => {
                        buyIcon.style.display = 'none';
                    });
                });

                // Calcular y mostrar subtotal, IVA y total
                calculateTotals(data.purchases);
            });
    }

    function calculateTotals(purchases) {
        const pricePerGuide = 5;
        let subtotal = purchases.length * pricePerGuide;
        let iva = subtotal * 0.12;
        let total = subtotal + iva;

        if (subtotalElement) {
            subtotalElement.textContent = '$' + subtotal.toFixed(2);
        }
        if (ivaElement) {
            ivaElement.textContent = '$' + iva.toFixed(2);
        }
        if (totalElement) {
            totalElement.textContent = '$' + total.toFixed(2);
        }
    }

    loadPurchases();

    // Agregar al carrito
    buyIcons.forEach(icon => {
        icon.onclick = function(event) {
            event.preventDefault();
            var id = icon.getAttribute('data-id');
            var title = icon.getAttribute('data-title');
            var price = parseFloat(icon.getAttribute('data-price'));
            alert('Sala ' + title + ' agregada al carrito.');

            // Actualizar el archivo JSON
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id, title: title, price: price })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    icon.style.display = 'none';
                    cartCount.innerText = data.cartCount;
                    localStorage.setItem('cartCount', data.cartCount); // Actualizar localStorage
                    loadPurchases(); // Volver a cargar las compras después de agregar al carrito
                } else {
                    alert(data.message);
                }
            });
        }
    });

    // Reproducir audio
    playIcons.forEach(icon => {
        icon.onclick = function(event) {
            event.preventDefault();
            var audio = icon.getAttribute('data-audio');
            audioSource.src = audio;
            audioPlayer.load();
            modal.style.display = "block";
            audioPlayer.play();
        }
    });

    // Cerrar modal
    span.onclick = function() {
        modal.style.display = "none";
        audioPlayer.pause();
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            audioPlayer.pause();
        }
    }
});
</script>
