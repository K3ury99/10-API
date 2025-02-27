<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Imagen AI</h1>

    <form method="get" action="ai_image.php" class="mb-5">
        <div class="row g-3 justify-content-center">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="keyword" 
                       name="keyword" 
                       placeholder="Ingresa una palabra clave" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Buscar Imagen
                </button>
            </div>
        </div>
    </form>

    <?php
    $access_key = "o0vYkOSG2FU1rGWer9QPbPHoWy_nYJ9_WGzZ5-XAsPA";

    if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
        $query = urlencode($_GET['keyword']);
    } else {
        // Si no hay búsqueda, se buscan imágenes aleatorias sin filtro
        $query = "random";
    }

    $url = "https://api.unsplash.com/photos/random?query=".$query."&client_id=".$access_key."&orientation=landscape&count=6";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo '<div class="alert alert-danger">Error al conectar con la API de Unsplash: '.curl_error($ch).'</div>';
    } else {
        $data = json_decode($response, true);
        if (is_array($data) && count($data) > 0) {
            echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
            foreach ($data as $image) {
                if (isset($image['urls']['regular'])) {
                    $image_url = $image['urls']['regular'];
                    echo '<div class="col">';
                    echo '<img src="'.$image_url.'" alt="Imagen" class="img-fluid rounded shadow" style="height:250px; object-fit:cover; width:100%;">';
                    echo '</div>';
                }
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning">No se encontraron imágenes.</div>';
        }
    }
    curl_close($ch);
    ?>

</div>

<?php include 'footer.php'; ?>
