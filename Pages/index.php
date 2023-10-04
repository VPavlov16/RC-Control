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
        <h5>RC Tank</h5>
        <p>Perfect for offroad!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/f1.jpg" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>RC F1</h5>
        <p>Perfect when you need speed!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="../images/boat.jpg" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5>RC Benchy</h5>
        <p>An answer for the water.</p>
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
    
</body>
</html>