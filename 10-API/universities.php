<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Universidades</h1>
    <form method="get" action="universities.php" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="country" 
                       name="country" 
                       placeholder="Ingresa el país en inglés" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Buscar
                </button>
            </div>
        </div>
    </form>

    <?php
    if(isset($_GET['country'])) {
        $country = urlencode($_GET['country']);
        $url = "http://universities.hipolabs.com/search?country=" . $country;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        if(curl_errno($ch)){
            echo '<div class="alert alert-danger">Error al conectar con la API: ' . curl_error($ch) . '</div>';
        } else {
            $universities = json_decode($response, true);
            if(is_array($universities) && count($universities) > 0) {
                echo '<ul class="list-group">';
                foreach($universities as $uni) {
                    echo '<li class="list-group-item">';
                    echo '<h5>' . htmlspecialchars($uni['name']) . '</h5>';
                    echo '<p>Dominio: ' . htmlspecialchars(implode(", ", $uni['domains'])) . '</p>';
                    echo '<a href="' . htmlspecialchars($uni['web_pages'][0]) . '" target="_blank">Visitar sitio</a>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<div class="alert alert-warning">No se encontraron universidades para ese país.</div>';
            }
        }
        curl_close($ch);
    }
    ?>
</div>

<?php include 'footer.php'; ?>
