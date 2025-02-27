<?php include 'header.php'; ?>
<style>
  /* Estilos para la card de chistes */
  .card-joke {
    width: 600px;
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    background: linear-gradient(135deg, #ffffff, #f9f9f9);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  .card-joke:hover {
    transform: scale(1.03);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  }
  .card-joke .card-body {
    padding: 2rem;
  }
  .card-title {
    font-family: 'Georgia', serif;
    font-size: 1.75rem;
    color: #333;
    text-align: center;
  }
  .card-text {
    font-family: 'Arial', sans-serif;
    font-size: 1.1rem;
    color: #555;
    text-align: center;
  }
  /* Estilos para el botón */
  .btn-refresh {
    background-color: #007bff; /* Azul */
    color: #fff;
    border: none;
    transition: background-color 0.3s, transform 0.3s;
  }
  .btn-refresh:hover {
    background-color: #0069d9;
    transform: translateY(-2px);
  }
</style>

<div class="container py-5">
  <h1 class="text-center mb-4">Chiste del Día</h1>
  <div class="text-center mb-4">
    <button onclick="location.reload()" class="btn btn-primary btn-refresh">Nuevo Chiste</button>
  </div>
  <?php
  $url = "https://v2.jokeapi.dev/joke/Any?lang=es";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  
  if(curl_errno($ch)){
    echo '<div class="alert alert-danger text-center">Error al conectar con la API de chistes: '.curl_error($ch).'</div>';
  } else {
    $joke = json_decode($response, true);
    if(isset($joke['error']) && $joke['error'] == true) {
      echo '<div class="alert alert-warning text-center">No se pudo obtener un chiste.</div>';
    } else {
      echo '<div class="card card-joke mx-auto">';
      echo '  <div class="card-body">';
      echo '    <h5 class="card-title">Chiste del Día</h5>';
      echo '    <hr>';
      if($joke['type'] == 'single') {
        echo '    <p class="card-text">'.htmlspecialchars($joke['joke']).'</p>';
      } else if($joke['type'] == 'twopart') {
        echo '    <p class="card-text">'.htmlspecialchars($joke['setup']).'</p>';
        echo '    <hr>';
        echo '    <p class="card-text">'.htmlspecialchars($joke['delivery']).'</p>';
      }
      echo '  </div>';
      echo '</div>';
    }
  }
  curl_close($ch);
  ?>
</div>

<?php include 'footer.php'; ?>
