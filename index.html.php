<?php

function carouselDisplay($images)
{
  $carouselInner = "";

  if (empty($images) || !is_array($images)) {
    $path = file_exists($images) ? $images : "https://psgpharma.ac.in/wp-content/uploads/2019/02/empty-img.jpg";
    $carouselItem = <<<HTML
        <div class="carousel-item active">
          <img src="{$path}" class="d-block w-100" alt="..." />
        </div>
    HTML;
    $carouselInner .= $carouselItem;
  } else {
    foreach ($images as $i => $image) {
      $path = file_exists($image) ? $image : "https://psgpharma.ac.in/wp-content/uploads/2019/02/empty-img.jpg";;
      $active = $i === 0 ? "active" : "";
      $carouselItem = <<<HTML
        <div class="carousel-item {$active}">
          <img src="{$path}" class="d-block w-100" alt="..." />
        </div>
    HTML;

      $carouselInner .= $carouselItem;
    }
  }

  $carouselWrapper = <<<HTML
        <div id="carouselWrapper" class="myCarousel carousel slide" data-bs-ride="carousel" style="width: 200px; height: 200px">
        
          <div class="carousel-inner">

          <!-- CAROUSEL ITEMS GOES -->
          <!-- HERE -->{$carouselInner}

          </div>

          <button class="carousel-control-prev" type="button" data-bs-target="#carouselWrapper" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselWrapper" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
  HTML;

  return $carouselWrapper;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <style>
    main {
      height: 100vh;
    }
  </style>
  <title>Carousel</title>
</head>

<body>
  <main class="border container d-flex justify-content-center align-items-center">

    <?php
    $images = [
      "./img/product/product_1.jpg",
      "./img/product/product_2.jpg",
      "./img/product/product_3.jpg",
      "./img/product/product_4.jpg",
      "./img/product/product_5.jpg"

    ];

    echo carouselDisplay($images);


    ?>


  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>