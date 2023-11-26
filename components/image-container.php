<?php

function showImageContainer($itemImage, $type)
{

    $mainElement = '';
    if (json_decode($itemImage)) {
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
        $mainElement = <<<HTML
        <div id="imageContainer" class="flex items-center justify-center w-full h-full relative p-4">
            <div class="swiper-container max-w-full h-full overflow-hidden space-x-4 flex transition-all transform">
                <div class="swiper-wrapper">
                    {$imgDisplay}
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>
        HTML;
    } else {
        $itemImage = file_exists($itemImage) ? $itemImage : "../img/$type/default.jpg";

        $mainElement = <<<HTML
            <img src="{$itemImage}" alt=" " class=" object-contain h-full w-full hover:scale-[.95] transform transition-all" />
        HTML;
    }

    echo $mainElement;
}
