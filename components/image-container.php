<?php
error_reporting(E_ERROR | E_PARSE);

function showImageContainer($itemImage, $type)
{

    $mainElement = '';
    if ($itemImage != null && json_decode($itemImage)) {
        $images = json_decode($itemImage, true);

        $imgDisplay = '';
        foreach ($images as $i) {
            $path = "../img/$type/" . $i['name'];
            $src = file_exists($path) ? $path : "../img/$type/default.jpg";

            $imgDiv = <<<HTML
            <div class="swiper-slide">
                <img src="{$src}" alt=" " class="object-contain h-full w-full hover:scale[.95] transform transition-all box-border" />
            </div>
            HTML;

            $imgDisplay .= $imgDiv;
        }
    } else {
        $itemImage = $itemImage != null && file_exists($itemImage) ? $itemImage : "../img/$type/default.jpg";

        $imgDisplay = <<<HTML
        <div class="swiper-slide">
            <img src="{$itemImage}" alt=" " class=" object-contain h-full w-full hover:scale-[.95] transform transition-all" />
        </div>
        
        HTML;
    }

    $mainElement = <<<HTML
    <div id="imageContainer" class="flex items-center justify-center w-full h-full relative p-4">
        <div class="swiper-container max-w-full h-full overflow-hidden flex transition-all transform">
            <div id="swiper-wrapper" class="swiper-wrapper px-2">
                {$imgDisplay}
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    HTML;

    echo $mainElement;
}
