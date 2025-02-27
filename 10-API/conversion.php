<?php include 'header.php'; ?>

<div class="container">
    <h1 class="mb-4 text-center">
        <i class="bi bi-cash-stack text-success"></i> Conversión de Moneda 
        <i class="bi bi-currency-exchange text-primary"></i>
    </h1>

    <?php
    // Generar un monto aleatorio entre 5 y 500 USD si no hay entrada del usuario
    $usd = isset($_POST['usd']) ? floatval($_POST['usd']) : rand(5, 500);
    
    // URL de la API de tasas de cambio
    $url = "https://open.er-api.com/v6/latest/USD";

    // Obtener tasas de cambio
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo '<div class="alert alert-danger">Error al conectar con la API de cambio: '.curl_error($ch).'</div>';
    } else {
        $rates = json_decode($response, true);
        if (isset($rates['rates'])) {
            // Lista de monedas a mostrar
            $currencies = [
                "🇩🇴 DOP" => ["rate" => "DOP", "icon" => "bi bi-coin text-warning"],
                "💶 EUR" => ["rate" => "EUR", "icon" => "bi bi-currency-euro text-primary"],
                "💷 GBP" => ["rate" => "GBP", "icon" => "bi bi-currency-pound text-danger"],
                "🇲🇽 MXN" => ["rate" => "MXN", "icon" => "bi bi-cash text-success"],
                "🇨🇦 CAD" => ["rate" => "CAD", "icon" => "bi bi-currency-dollar text-info"],
                "🇧🇷 BRL" => ["rate" => "BRL", "icon" => "bi bi-currency-bitcoin text-warning"],
                "🇯🇵 JPY" => ["rate" => "JPY", "icon" => "bi bi-currency-yen text-danger"],
                "🇦🇷 ARS" => ["rate" => "ARS", "icon" => "bi bi-cash-coin text-secondary"],
                "🇨🇭 CHF" => ["rate" => "CHF", "icon" => "bi bi-currency-dollar text-success"],
                "🇦🇺 AUD" => ["rate" => "AUD", "icon" => "bi bi-currency-dollar text-info"],
            ];
    ?>

    <form method="post" action="conversion.php" class="mb-5">
        <div class="row g-3">
            <div class="col-md-9">
                <input type="number" 
                       step="0.01" 
                       class="form-control form-control-lg" 
                       id="usd" 
                       name="usd" 
                       placeholder="Cantidad en USD" 
                       value="<?= htmlspecialchars($usd) ?>"
                       required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-currency-exchange me-2"></i>Convertir
                </button>
            </div>
        </div>
    </form>

    <div class="card mx-auto shadow-lg" style="max-width: 40rem; border-radius: 15px;">
        <div class="card-header text-white text-center py-3" style="background-color: #007bff; border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <h4 class="mb-0"><i class="bi bi-calculator"></i> Resultado de Conversión</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <?php
                foreach ($currencies as $name => $currency) {
                    $rate = isset($rates['rates'][$currency['rate']]) ? $rates['rates'][$currency['rate']] : 0;
                    $converted = $usd * $rate;
                    echo '<div class="col-md-6 mb-2">';
                    echo '<p class="fs-5"><i class="'.$currency['icon'].' me-2"></i><strong>'.$name.':</strong> '.number_format($converted, 2).'</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php
        } else {
            echo '<div class="alert alert-warning">No se pudieron obtener las tasas de cambio.</div>';
        }
    }
    curl_close($ch);
    ?>

</div>

<?php include 'footer.php'; ?>
