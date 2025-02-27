<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">Género</h1>
    <form method="post" action="gender.php" class="mb-5">
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
                    <i class="bi bi-search me-2"></i>Predecir
                </button>
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST['name'])) {
        $name = urlencode($_POST['name']);
        $url = "https://api.genderize.io/?name=" . $name;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo '<div class="alert alert-danger">Error al conectar con la API: ' . curl_error($ch) . '</div>';
        } else {
            $data = json_decode($response, true);
            if (isset($data['gender']) && $data['gender'] != null) {
                $color = ($data['gender'] == 'male') ? '#007bff' : '#ff4d4d';
                echo '<div class="alert" style="color:' . $color . '">';
                echo 'El género predicho para <strong>' . htmlspecialchars($_POST['name']) . '</strong> es: <strong>' . htmlspecialchars($data['gender']) . '</strong>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-warning">No se pudo predecir el género para ese nombre.</div>';
            }
        }
        curl_close($ch);
    }
    ?>
</div>

<?php include 'footer.php'; ?>
