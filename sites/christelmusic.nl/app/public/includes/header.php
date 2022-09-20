<?php
/**
 * @var ?string $pageName
 * @var ?ReleaseProject $releaseProject
 */

use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\ReleaseProject;

if (!isset($releaseProject)) {
    $releaseProject = new Landslide();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:image" content="https://www.christelmusic.nl<?=$releaseProject->getOgImageUrl()?>" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link href="./assets/theme.css?ver=<?=md5_file('./assets/theme.css')?>" rel="stylesheet"/>

    <script src="https://kit.fontawesome.com/f0b0cd2378.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>Christel Music<?php if(isset($pageName)) { echo ' - ' . $pageName; } ?></title>
</head>
<body>

<div class="page-background d-none d-lg-block"></div>

<div class="container-lg">
    <header class="row mt-4 g-0">
        <div class="col-xs-12">
            <a href="/"><img src="<?=$releaseProject->getHeaderImageUrl()?>" class="img-fluid"/></a>
        </div>
    </header>

    <main class="row g-0">
        <div class="container bg-white p-4">
            <div class="row social-icons">
                <p>
                    <!-- Spotify -->
                    <a href="https://open.spotify.com/artist/29x4lHXIQ1GiDMf6N4RofZ?si=pDJ1phBwT7OEKL5-t6XRcg"
                       target="_blank">
                        <i class="fab fa-spotify"></i>
                    </a>
                    <!-- Soundcloud -->
                    <a href="https://soundcloud.com/christel-hoogendoorn" target="_blank">
                        <i class="fab fa-soundcloud"></i>
                    </a>
                    <!-- Instagram -->
                    <a href="https://www.instagram.com/christelhoogendoorn/" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <!-- Youtube -->
                    <a href="https://www.youtube.com/channel/UC7jb3q5SxNX85NVo5X3vSHQ" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/christel.hoogendoorn" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </p>
            </div>
