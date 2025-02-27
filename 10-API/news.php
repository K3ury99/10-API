<?php include 'header.php'; ?>
<h1 class="text-center">Noticias</h1>
<div class="row">
  <?php
  $url = "https://wordpress.org/news/wp-json/wp/v2/posts?per_page=3";
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if(curl_errno($ch)){
      echo '<div class="alert alert-danger w-100">Error al conectar con la API de noticias: '.curl_error($ch).'</div>';
  } else {
      $posts = json_decode($response, true);
      if(is_array($posts) && count($posts) > 0) {
          foreach($posts as $post) {
              echo '<div class="col-md-4 mb-3">';
              echo '  <div class="card h-100">';
              echo '    <div class="card-body d-flex flex-column">';
              echo '      <h5 class="card-title">'.htmlspecialchars($post['title']['rendered']).'</h5>';
              echo '      <p class="card-text flex-grow-1">'.strip_tags($post['excerpt']['rendered']).'</p>';
              echo '      <a href="'.htmlspecialchars($post['link']).'" class="btn btn-primary mt-auto" target="_blank">Leer más</a>';
              echo '    </div>';
              echo '  </div>';
              echo '</div>';
          }
      } else {
          echo '<div class="alert alert-warning w-100">No se encontraron noticias.</div>';
      }
  }
  curl_close($ch);
  ?>
</div>
<?php include 'footer.php'; ?>


