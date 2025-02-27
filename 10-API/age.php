<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Edades</h1>
    <form method="post" action="age.php" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="text" 
                       class="form-control form-control-lg" 
                       id="name" 
                       name="name" 
                       placeholder="Ingresa un nombre" 
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search me-2"></i>Predecir Edad
                </button>
            </div>
        </div>
    </form>

    <?php
    if(isset($_POST['name'])) {
        $name = urlencode($_POST['name']);
        $url = "https://api.agify.io/?name=" . $name;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        if(curl_errno($ch)){
            echo '<div class="alert alert-danger mt-3">Error al conectar con la API: ' . curl_error($ch) . '</div>';
        } else {
            $data = json_decode($response, true);
            if(isset($data['age']) && $data['age'] != null) {
                $age = $data['age'];
                if($age < 18) {
                    $category = 'Joven 👶';
                    $img = 'assets/images/joven.png';
                } elseif($age < 60) {
                    $category = 'Adulto 🧑';
                    $img = 'assets/images/adulto.png';
                } else {
                    $category = 'Anciano 👴';
                    $img = 'assets/images/anciano.png';
                }
                echo '<div class="alert alert-info mt-3">';
                echo 'La edad estimada para <strong>' . htmlspecialchars($_POST['name']) . '</strong> es <strong>' . $age . '</strong> años. Categoría: ' . $category;
                echo '<br><img src="' . $img . '" alt="' . $category . '" style="max-width:100px;">';
                echo '</div>';
            } else {
                echo '<div class="alert alert-warning mt-3">No se pudo predecir la edad para ese nombre.</div>';
            }
        }
        curl_close($ch);
    }
    ?>
</div>

<?php include 'footer.php'; ?>
