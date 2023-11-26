<?php
$rootName = array_reverse(explode("/", str_replace('\\', '/', dirname(__DIR__))))[0];
$referrer = $_SERVER['REQUEST_URI'] ?? null;


$relativePath = '';
if ($referrer) {
    $referrerParts = explode("/", explode($rootName, $referrer)[1]);
    $slashCount = count($referrerParts) - 2;
    $relativePath = str_repeat('..' . "/", $slashCount);
}

$css_dir = $relativePath . '/css';
$img_dir = $relativePath . '/img';
$js_dir = $relativePath . '/js';

?>


<!-- change icon -->
<link rel="icon" href="<?= $img_dir ?>/storeIcon.ico">
<link rel="stylesheet" href="<?= $css_dir ?>/main.css">

<!-- FontAwesome 6.2.0 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- (Optional) Use CSS or JS implementation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js" integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


<!-- tailwind -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- <script src="https://cdn.tailwindcss.com"></script> -->