<?php

use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\ReleaseProject;
use ChristelMusic\Releases\Watershed;

require_once '../vendor/autoload.php';
require './includes/header.php';
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <p class="lead">Classical pianist, composer.</p>
        <p>Christel was born in the Netherlands. At age ten, she taught herself to play the piano. In 2019 she
            discovered her passion for composing music. Although Christel has a love for many different music genres,
            the music she writes is mainly influenced by (neo)classical and cinematic music.</p>
        <p>In 2021 she released her first album 'Watershed'. It is a collection of solo piano songs that reflect
            different moods. Whether it’s peaceful, uplifting, energetic, dramatic or epic, it’s always passionate. “I
            get really excited when I notice that my mood changes when I play a certain piece.”</p>
        <p>Her second album 'Landslide' will be released in October 2022.</p>
    </div>
</div>

<?php
/** @var ReleaseProject[] $releases */
$releases = [
    new Landslide(),
    new Watershed(),
];
?>

<?php foreach ($releases as $release): ?>
<div class="row mt-5">
    <div class="col-md-12">
        <p>
            <a href="/<?=$release->getSlug();?>">
                <img src="<?=$release->getProjectImageUrl()?>" alt="<?=$release->getTitle()?>" class="img-fluid border"/>
            </a>
        </p>
    </div>
</div>
<?php endforeach; ?>

<?php require './includes/footer.php'; ?>
