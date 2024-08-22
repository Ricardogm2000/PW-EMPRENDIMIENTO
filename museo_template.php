<?php include 'header.php';?>

<div class="container">
    <h1 class="title"><?php echo $museumTitle; ?></h1>
    <div class="row">
        <div class="col-md-12">
            <div class="row gallery">
                <?php 
                    foreach($rooms as $room) {
                        echo '<div class="col-sm-6 col-md-3 wowload fadeInUp gallery-item">';
                        echo '<div class="gallery-image-container">';
                        echo '<img src="'.$room["src"].'" class="img-responsive" alt="'.$room["title"].'">';
                        echo '<div class="overlay">';
                        echo '<div class="overlay-content">';
                        echo '<div class="language-options">';
                        echo '<a href="#" class="icon buy-icon" data-id="'.$room["id"].'" data-title="'.$room["title"].'"><i class="fa fa-shopping-cart"></i> Comprar</a>';
                        echo '<a href="#" class="icon play-icon" data-audio="'.$room["audio_es"].'" data-id="'.$room["id"].'" style="display:none;"><i class="fa fa-play"></i> Español</a>';
                        echo '<a href="#" class="icon play-icon" data-audio="'.$room["audio_ru"].'" data-id="'.$room["id"].'" style="display:none;"><i class="fa fa-play"></i> Русский</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="gallery-title">'.$room["title"].'</div>';
                        echo '<p>'.$room["info"].'</p>';
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

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    var modal = document.getElementById("audioModal");
    var audioPlayer = document.getElementById("audioPlayer");
    var audioSource = document.getElementById("audioSource");
    var playIcons = document.querySelectorAll(".play-icon");
    var buyIcons = document.querySelectorAll(".buy-icon");
    var span = document.getElementsByClassName("close")[0];
    var cartCount = document.getElementById("cart-count");

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
            });
    }

    loadPurchases();

    // Agregar al carrito
    buyIcons.forEach(icon => {
        icon.onclick = function(event) {
            event.preventDefault();
            var id = icon.getAttribute('data-id');
            var title = icon.getAttribute('data-title');
            alert('Sala ' + title + ' agregada al carrito.');

            // Actualizar el archivo JSON
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: id, title: title })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    icon.style.display = 'none';
                    cartCount.innerText = data.cartCount;
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