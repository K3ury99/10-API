<?php include 'header.php'; ?>
<style>
  .hero-section {
    padding: 20px;
    margin-top: 0;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    /* Sin altura fija para evitar scroll */
  }
  .hero-section h1 {
    font-size: 2.75rem;
    font-weight: bold;
    color: #007bff;
  }
  .hero-section p.lead {
    font-size: 1.25rem;
    color: #333;
    margin-bottom: 30px;
    text-align: center;
  }
  .hero-section img {
    border-radius: 50%;
    max-width: 300px;
    transition: transform 0.3s;
  }
  .hero-section img:hover {
    transform: scale(1.05);
  }
  .hero-section h2 {
    font-size: 2rem;
    font-weight: 300;
    color: #555;
    margin-top: 20px;
  }
</style>

<div class="hero-section text-center">
  <h1>Bienvenido a KORTEX Portal de APIs</h1>
  <p class="lead">Soy un programador apasionado por transformar ideas en soluciones. Cada API que integro es un paso más en mi viaje de innovación y creatividad. ¡Bienvenido a mi mundo digital!</p>
  <img src="assets/images/pasaporte.jpg" alt="Foto Pasaporte" class="img-thumbnail">
  <h2>Keury Ramírez</h2>
</div>

<?php include 'footer.php'; ?>
