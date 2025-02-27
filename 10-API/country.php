<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Paises</h1>
    
    <form method="GET" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="country" 
                       name="country" 
                       placeholder="Ejemplo: Dominican Republic" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Buscar País
                </button>
            </div>
        </div>
    </form>

    <?php
    $allCountries = true;
    
    if(isset($_GET['country']) && !empty($_GET['country'])) {
        $allCountries = false;
        $country = rawurlencode(trim($_GET['country']));
        $url = "https://restcountries.com/v3.1/name/".$country;
    } else {
        $url = "https://restcountries.com/v3.1/all";
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MiApp/1.0; +http://tusitio.com)');
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        echo '<div class="alert alert-danger">Error de conexión: ' . $curl_error . '</div>';
    } else {
        $data = json_decode($response, true);

        if ($http_code == 200 && is_array($data)) {
            if (!$allCountries) {
                if (isset($data[0])) {
                    $data = [$data[0]]; // Tomar solo el primer país encontrado
                } else {
                    echo '<div class="alert alert-warning">No se encontraron datos para el país ingresado.</div>';
                    $data = [];
                }
            }

            if ($allCountries) {
                // Mostrar todos los países en tres columnas en pantallas grandes
                echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
            }

            foreach ($data as $pais) {
                $flag = $pais['flags']['png'] ?? '';
                $capital = $pais['capital'][0] ?? 'N/A';
                $population = number_format($pais['population'] ?? 0);
                $currencies = isset($pais['currencies']) ? implode(", ", array_keys($pais['currencies'])) : 'N/A';

                // Si se busca un país, se muestra centrado y ancho
                if (!$allCountries) {
                    echo '<div class="d-flex justify-content-center">';
                } else {
                    echo '<div class="col">';
                }
                ?>
                
                <div class="card shadow <?= !$allCountries ? 'w-75' : 'h-100' ?>">
                    <div class="card-body">
                        <h2 class="mb-3 text-center"><?= htmlspecialchars($pais['name']['common']) ?></h2>
                        
                        <div class="text-center mb-3">
                            <?php if ($flag): ?>
                                <img src="<?= $flag ?>" 
                                     alt="Bandera de <?= htmlspecialchars($pais['name']['common']) ?>" 
                                     class="img-fluid rounded shadow-sm" 
                                     style="max-width: 200px;">
                            <?php endif; ?>
                        </div>
                        
                        <p class="fs-5"><span class="fw-bold">🏟 Capital:</span> <?= htmlspecialchars($capital) ?></p>
                        <p class="fs-5"><span class="fw-bold">🐱‍👤 Población:</span> <?= htmlspecialchars($population) ?></p>
                        <p class="fs-5"><span class="fw-bold">💶 Moneda(s):</span> <?= htmlspecialchars($currencies) ?></p>
                    </div>
                </div>

                </div> <!-- Cierre de la columna o contenedor centrado -->

                <?php
            }

            if ($allCountries) {
                echo '</div>'; // Cierre de row para múltiples países
            }
        } else {
            echo '<div class="alert alert-warning">No se pudieron obtener los datos.</div>';
        }
    }
    ?>

</div>

<?php include 'footer.php'; ?>
