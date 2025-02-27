<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Pokemones</h1>

    <form method="post" action="pokemon.php" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="pokemon" 
                       name="pokemon" 
                       placeholder="Ej. Pikachu" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Buscar Pokémon
                </button>
            </div>
        </div>
    </form>

    <?php
    if(isset($_POST['pokemon'])) {
        // Buscar un Pokémon específico
        $pokemon = strtolower(urlencode($_POST['pokemon']));
        $url = "https://pokeapi.co/api/v2/pokemon/".$pokemon;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if(curl_errno($ch)){
            echo '<div class="alert alert-danger">Error al conectar con la API: '.curl_error($ch).'</div>';
        } else {
            $data = json_decode($response, true);
            if(isset($data['name'])) {
                echo '<div class="d-flex justify-content-center">';
                echo '<div class="card text-center shadow-lg" style="width: 18rem; border-radius: 12px;">';
                echo '<img src="'.$data['sprites']['front_default'].'" class="card-img-top p-3" style="max-width: 120px; margin: auto;" alt="'.htmlspecialchars($data['name']).'">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title text-capitalize">'.htmlspecialchars($data['name']).'</h4>';
                echo '<p class="fs-6"><strong>Experiencia Base:</strong> '.$data['base_experience'].'</p>';
                
                // Agregar más detalles
                echo '<p class="fs-6"><strong>Altura:</strong> '.($data['height'] / 10).' m</p>';
                echo '<p class="fs-6"><strong>Peso:</strong> '.($data['weight'] / 10).' kg</p>';
                
                echo '<p class="fs-6"><strong>Tipos:</strong> ';
                $types = array_map(function($type){ return ucfirst($type['type']['name']); }, $data['types']);
                echo implode(", ", $types);
                echo '</p>';
                
                echo '<p class="fs-6"><strong>Habilidades:</strong> ';
                $abilities = array_map(function($ab){ return ucfirst($ab['ability']['name']); }, $data['abilities']);
                echo implode(", ", $abilities);
                echo '</p>';
                
                echo '</div></div></div>';
            } else {
                echo '<div class="alert alert-warning">No se encontró información para ese Pokémon.</div>';
            }
        }
        curl_close($ch);
    } else {
        // Mostrar 20 Pokémon aleatorios por defecto
        echo '<div class="row">';
        for ($i = 0; $i < 20; $i++) {
            $random_id = rand(1, 898); // Hay 898 Pokémon en la API
            $url = "https://pokeapi.co/api/v2/pokemon/".$random_id;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            if (!curl_errno($ch)) {
                $data = json_decode($response, true);
                if (isset($data['name'])) {
                    echo '<div class="col-md-4 mb-3">';
                    echo '<div class="card text-center shadow-sm" style="border-radius: 12px; padding: 15px;">';
                    echo '<img src="'.$data['sprites']['front_default'].'" class="card-img-top p-2" style="max-width: 120px; margin: auto;" alt="'.htmlspecialchars($data['name']).'">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title text-capitalize">'.htmlspecialchars($data['name']).'</h5>';
                    echo '</div></div></div>';
                }
            }
            curl_close($ch);
        }
        echo '</div>';
    }
    ?>

</div>

<?php include 'footer.php'; ?>
