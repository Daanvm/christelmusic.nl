<?php

require_once dirname(__FILE__).'/../vendor/autoload.php';

$jewelcaseImg = new imagick(dirname(__FILE__) . "/../public/assets/images/jewelcase_watershed.jpg");
$albumImg = new imagick(dirname(__FILE__) . "/../public/assets/images/landslide.jpg");

//$albumImg->setimagebackgroundcolor("#fad888");
$albumImg->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
$albumImg->distortImage(
    Imagick::DISTORTION_PERSPECTIVE,
    [
        // top left:
        0,0, 72,101,

        // top right:
        $albumImg->getImageWidth(),0, 345,27,

        // bottom left:
        0,$albumImg->getImageHeight(), 188,320,

        // bottom right:
        $albumImg->getImageWidth(),$albumImg->getImageHeight(), 478,231,
    ],
    true
);

$jewelcaseImg->compositeImage($albumImg, Imagick::COMPOSITE_DEFAULT, 72, 27);

$jewelcaseImg->writeImage('./jewelcase_output-' . date('c') . '.jpg');
