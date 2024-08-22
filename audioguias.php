<?php include 'header.php';?>
<div class="container">
    <h1 class="title">Audio Guías</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="row gallery">
                <?php 
                    $images = [
                        ["src" => "images/Museos/ciudad.png", "title" => "MUSEO DE LA CIUDAD", "info" => 
                        "Descubre la historia de Quito de una manera diferente en el Museo de la Ciudad. Se ubica en las instalaciones del Antiguo 
                        Hospital San Juan de Dios, que funcionó desde 1565 hasta 1974, con un permanente espíritu de servicio para todos los habitantes 
                        de la ciudad.
                        El Museo de la Ciudad es un espacio de encuentro, que en 1998 abrió sus puertas para la reflexión y el debate sobre los procesos 
                        socio-culturales de Quito. Además, aporta al desarrollo de las comunidades y promueve el reconocimiento y revalorización de los 
                        patrimonios culturales vivos del Distrito Metropolitano de Quito, desde enfoques de lo intercultural e intergeneracional.",
                        "link" => "museociudad.php"],

                        ["src" => "images/Museos/Carmen.png", "title" => "MUSEO DEL CARMEN ALTO", "info" => 
                        "El Museo del Carmen Alto, ubicado en Arequipa, Perú, es un destacado espacio cultural 
                        que alberga una rica colección de arte religioso y piezas históricas, muchas de las cuales 
                        provienen del convento de las Carmelitas Descalzas. Este museo no solo ofrece una visión 
                        profunda de la historia y la espiritualidad de la región, sino que también destaca por su 
                        arquitectura colonial y sus hermosos jardines. Los visitantes pueden explorar exposiciones 
                        que incluyen esculturas, pinturas y textiles, todo en un ambiente que invita a la reflexión
                         y el aprendizaje sobre la herencia cultural arequipeña.",
                        "link" => "museocarmen.php"],

                        ["src" => "images/Museos/Francisco.png", "title" => "MUSEO SAN FRANCISO", "info" => 
                        "El Museo de San Francisco, ubicado en Quito, Ecuador, es uno de los museos más importantes 
                        del país y un destacado ejemplo de la arquitectura colonial. Este museo se encuentra en el 
                        antiguo convento de San Francisco, fundado en el siglo XVI, y alberga una rica colección de 
                        arte religioso, que incluye pinturas, esculturas y objetos litúrgicos de gran valor histórico 
                        y cultural. Además, el museo ofrece una visión profunda de la historia de Quito y su desarrollo 
                        a lo largo de los siglos. Los visitantes pueden disfrutar de su impresionante arquitectura, 
                        así como de exposiciones temporales que destacan el arte contemporáneo ecuatoriano. Sin duda, 
                        es un lugar esencial para entender la herencia cultural del Ecuador.",
                        "link" => "museoguaysamin.php"],

                        ["src" => "images/Museos/Cera.png", "title" => "MUSEO DE CERA", "info" => "El Museo de Cera de Quito es una atracción única que ofrece 
                        a los visitantes una experiencia fascinante a través de figuras de cera que representan a diversas personalidades históricas, 
                        culturales y contemporáneas. Ubicado en el corazón de la ciudad, el museo destaca por su cuidadosa elaboración de las estatuas, 
                        que permiten a los visitantes interactuar con la historia de Ecuador y el mundo. Además, el ambiente del museo es acogedor, lo que 
                        lo convierte en un lugar ideal para familias y turistas que buscan aprender y divertirse al mismo tiempo.",
                        "link" => "museocera.php"],
                    ];

                    foreach($images as $index => $image) {
                        echo '<div class="col-sm-6 col-md-4 wowload fadeInUp gallery-item" data-info="'.$image["info"].'">';
                        echo '<div class="gallery-image-container">';
                        echo '<a href="'.$image["link"].'"><img src="'.$image["src"].'" class="img-responsive" alt="'.$image["title"].'"></a>';
                        echo '<div class="overlay">';
                        echo '<div class="overlay-content">';
                        echo '<a href="'.$image["link"].'" class="icon view-icon" data-index="'.$index.'"><i class="fa fa-eye"></i></a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="gallery-title">'.$image["title"].'</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div id="museum-info" class="museum-info">
                <h2>Información del Museo</h2>
                <p>Pasa el mouse sobre una imagen para ver la información del museo aquí.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    // Mostrar información del museo al pasar el mouse por encima de una imagen
    var galleryItems = document.querySelectorAll('.gallery-item');
    var museumInfo = document.getElementById('museum-info');

    galleryItems.forEach(item => {
        item.addEventListener('mouseover', function() {
            var info = item.getAttribute('data-info');
            museumInfo.innerHTML = '<h2>Información del Museo</h2><p>' + info + '</p>';
        });

        item.addEventListener('mouseout', function() {
            museumInfo.innerHTML = '<h2>Información del Museo</h2><p>Pasa el mouse sobre una imagen para ver la información del museo aquí.</p>';
        });
    });
});
</script>