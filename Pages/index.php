<?php 
require "nav.php";
?>


<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/homest.css">
    <link rel="stylesheet" href="../CSS/bootstrap.css">
    <script src="../JS/bootstrap.js"></script>
</head>
<body>
<div id="carouselExampleCaptions" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="../images/tankjpg.jpg" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Танк 1.0</h5>
        <p>Перфектен за всякакви условия!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/f1.jpg" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>F1</h5>
        <p>Когато ви трябва скорост, F1 ще Ви свърши работа!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/boat.jpg" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>Бенчи Лодка</h5>
        <p>Решението за водата.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!--  Mid section s iconci   -->
<div class="container px-4 py-5" id="featured-3">
    <h2 class="pb-2 border-bottom">Обща информация</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
      <!-- pravila -->
      <div class="feature col">
        <div class="icondiv">
          <img id="ruleicon" src="../icons/rules.png" alt="rules">
      </div>
        <h3 class="fs-2 ruleh3 text-body-emphasis">Правила</h3>
        <ol class="ordered-list">
          <li>Всеки има по 10 безплатни минути игра на ден.</li>
          <li>Без нарочно блъскане и чупене на моделите.</li>
          <li>Не споделяйте паролата си с никого!</li>
          <li>Гонките са позволени!</li>
          <li>И най-важното, забавлявайте се!</li>
          <h5 class="rules">При нарушаване на някое от горе показаните правила, извършителят ще бъде наказан!</h>
        </ol>
      </div>

      <!-- cenoraspis -->
      <div class="feature col">
        <div class="icondiv">
          <img id="ruleicon" src="../icons/money.png" alt="rules">
      </div>
        <h3 class="fs-2 ruleh3 text-body-emphasis">Ценоразпис на пакети</h3>
        <ol class="ordered-list prices">
          <li>Малък пакет - 10лв</li>
          <li>Среден пакет - 18лв.</li>
          <li>Голям пакет - 28лв</li>
          <li>Гига пакет - 40лв</li>
        </ol>
        <a class="plink" href="prices.php">За повече информация натиснете тук.</a>
      </div>

      <!-- contact us  -->
      <form action="#" method="POST">
      <div class="feature col">
        <div class="icondiv">
          <img id="ruleicon" src="../icons/help.png" alt="rules">
      </div>
        <h3 class="fs-2 ruleh3 text-body-emphasis">Имате нужда от помощ?</h3>
        <div class="probDiv">
        <label for="email">Въведете вашият E-mail: </label>
        <input type="text" class ="email" placeholder="E-mail" name="email" id="email" required>
        <label for="problem">Въведете проблема Ви:  </label>
        <textarea rows=3 cols=23  class ="problem" placeholder="Въведете вашият проблем/въпрос тук!" name="problem" id="problem  " required></textarea>
        <button type="submit" class="btn btn-primary btn-lg btn-block" id="submit" name="submit">Изпращане</button>
        </div>

      </div>
      </form>

    </div>
  </div>
    
</body>
</html>