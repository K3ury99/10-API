<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Climas</h1>

    <form method="get" action="weather.php" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="city" 
                       name="city" 
                       placeholder="Ingresa una ciudad" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Buscar Clima
                </button>
            </div>
        </div>
    </form>

    <?php
    if(isset($_GET['city'])) {
        $city = urlencode($_GET['city']);
        $geo_url = "https://geocoding-api.open-meteo.com/v1/search?name=".$city."&count=1";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $geo_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $geo_response = curl_exec($ch);

        if(curl_errno($ch)){
            echo '<div class="alert alert-danger">Error al conectar con la API de geocodificación: '.curl_error($ch).'</div>';
        } else {
            $geo_data = json_decode($geo_response, true);
            if(isset($geo_data['results'][0])) {
                $lat = $geo_data['results'][0]['latitude'];
                $lon = $geo_data['results'][0]['longitude'];
                $weather_url = "https://api.open-meteo.com/v1/forecast?latitude=".$lat."&longitude=".$lon."&current_weather=true";
                curl_setopt($ch, CURLOPT_URL, $weather_url);
                $weather_response = curl_exec($ch);

                if(curl_errno($ch)){
                    echo '<div class="alert alert-danger">Error al conectar con la API de clima: '.curl_error($ch).'</div>';
                } else {
                    $weather_data = json_decode($weather_response, true);
                    if(isset($weather_data['current_weather'])) {
                        $temp = $weather_data['current_weather']['temperature'];
                        $weathercode = $weather_data['current_weather']['weathercode'];
                        
                        $weather_conditions = [
                            0 => ["Despejado ☀️", "#ffe680"],
                            1 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                            2 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                            3 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                            45 => ["Neblina 🌫️", "#a3c2c2"],
                            48 => ["Neblina 🌫️", "#a3c2c2"],
                            51 => ["Lluvioso 🌧️", "#a3c2c2"],
                            53 => ["Lluvioso 🌧️", "#a3c2c2"],
                            55 => ["Lluvioso 🌧️", "#a3c2c2"],
                            56 => ["Lluvioso 🌧️", "#a3c2c2"],
                            57 => ["Lluvioso 🌧️", "#a3c2c2"],
                            61 => ["Lluvioso 🌧️", "#a3c2c2"],
                            63 => ["Lluvioso 🌧️", "#a3c2c2"],
                            65 => ["Lluvioso 🌧️", "#a3c2c2"],
                            80 => ["Lluvioso 🌧️", "#a3c2c2"],
                            81 => ["Lluvioso 🌧️", "#a3c2c2"],
                            82 => ["Lluvioso 🌧️", "#a3c2c2"],
                            71 => ["Nevado ❄️", "#e0f7fa"],
                            73 => ["Nevado ❄️", "#e0f7fa"],
                            75 => ["Nevado ❄️", "#e0f7fa"],
                            77 => ["Nevado ❄️", "#e0f7fa"],
                            85 => ["Nevado ❄️", "#e0f7fa"],
                            86 => ["Nevado ❄️", "#e0f7fa"],
                            95 => ["Tormenta ⛈️", "#ffcccc"],
                            96 => ["Tormenta ⛈️", "#ffcccc"],
                            99 => ["Tormenta ⛈️", "#ffcccc"]
                        ];

                        $condition = $weather_conditions[$weathercode] ?? ["Desconocido 🌡️", "#f0f0f0"];
                        
                        echo '<div class="p-4 text-center rounded shadow" style="background-color:'.$condition[1].';">';
                        echo '<h3>Clima en '.htmlspecialchars($_GET['city']).'</h3>';
                        echo '<p style="font-size:3rem;">'.$condition[0].'</p>';
                        echo '<p class="fs-4">🌡️ Temperatura: <strong>'.$temp.' °C</strong></p>';
                        echo '</div>';
                    } else {
                        echo '<div class="alert alert-warning">No se pudo obtener el clima para esa ciudad.</div>';
                    }
                }
            } else {
                echo '<div class="alert alert-warning">No se encontraron coordenadas para esa ciudad.</div>';
            }
        }
        curl_close($ch);
    } else {
        // Mostrar climas de países aleatorios por defecto
        echo '<div class="row">';
        $countries = ['Argentina', 'Brasil', 'Chile', 'Colombia', 'México', 'España', 'Francia', 'Italia', 'Alemania', 'Reino Unido'];
        
        // Asegurarse de que siempre se muestran 3 países
        for ($i = 0; $i < 3; $i++) {
            $random_country = $countries[array_rand($countries)]; // Seleccionar un país aleatorio
            $geo_url = "https://geocoding-api.open-meteo.com/v1/search?name=".$random_country."&count=1";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $geo_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $geo_response = curl_exec($ch);

            if(curl_errno($ch)){
                echo '<div class="alert alert-danger">Error al conectar con la API de geocodificación: '.curl_error($ch).'</div>';
            } else {
                $geo_data = json_decode($geo_response, true);
                if(isset($geo_data['results'][0])) {
                    $lat = $geo_data['results'][0]['latitude'];
                    $lon = $geo_data['results'][0]['longitude'];
                    $weather_url = "https://api.open-meteo.com/v1/forecast?latitude=".$lat."&longitude=".$lon."&current_weather=true";
                    curl_setopt($ch, CURLOPT_URL, $weather_url);
                    $weather_response = curl_exec($ch);

                    if(curl_errno($ch)){
                        echo '<div class="alert alert-danger">Error al conectar con la API de clima: '.curl_error($ch).'</div>';
                    } else {
                        $weather_data = json_decode($weather_response, true);
                        if(isset($weather_data['current_weather'])) {
                            $temp = $weather_data['current_weather']['temperature'];
                            $weathercode = $weather_data['current_weather']['weathercode'];
                            
                            $weather_conditions = [
                                0 => ["Despejado ☀️", "#ffe680"],
                                1 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                                2 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                                3 => ["Parcialmente nublado ⛅", "#d9d9d9"],
                                45 => ["Neblina 🌫️", "#a3c2c2"],
                                48 => ["Neblina 🌫️", "#a3c2c2"],
                                51 => ["Lluvioso 🌧️", "#a3c2c2"],
                                53 => ["Lluvioso 🌧️", "#a3c2c2"],
                                55 => ["Lluvioso 🌧️", "#a3c2c2"],
                                56 => ["Lluvioso 🌧️", "#a3c2c2"],
                                57 => ["Lluvioso 🌧️", "#a3c2c2"],
                                61 => ["Lluvioso 🌧️", "#a3c2c2"],
                                63 => ["Lluvioso 🌧️", "#a3c2c2"],
                                65 => ["Lluvioso 🌧️", "#a3c2c2"],
                                80 => ["Lluvioso 🌧️", "#a3c2c2"],
                                81 => ["Lluvioso 🌧️", "#a3c2c2"],
                                82 => ["Lluvioso 🌧️", "#a3c2c2"],
                                71 => ["Nevado ❄️", "#e0f7fa"],
                                73 => ["Nevado ❄️", "#e0f7fa"],
                                75 => ["Nevado ❄️", "#e0f7fa"],
                                77 => ["Nevado ❄️", "#e0f7fa"],
                                85 => ["Nevado ❄️", "#e0f7fa"],
                                86 => ["Nevado ❄️", "#e0f7fa"],
                                95 => ["Tormenta ⛈️", "#ffcccc"],
                                96 => ["Tormenta ⛈️", "#ffcccc"],
                                99 => ["Tormenta ⛈️", "#ffcccc"]
                            ];

                            $condition = $weather_conditions[$weathercode] ?? ["Desconocido 🌡️", "#f0f0f0"];
                            
                            echo '<div class="col-md-4 mb-3">';
                            echo '<div class="p-4 text-center rounded shadow" style="background-color:'.$condition[1].';">';
                            echo '<h3>Clima en '.htmlspecialchars($random_country).'</h3>';
                            echo '<p style="font-size:3rem;">'.$condition[0].'</p>';
                            echo '<p class="fs-4">🌡️ Temperatura: <strong>'.$temp.' °C</strong></p>';
                            echo '</div></div>';
                        }
                    }
                }
            }
            curl_close($ch);
        }
        echo '</div>';
    }
    ?>
</div>

<?php include 'footer.php'; ?>
