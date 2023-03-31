<?php

use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\OnlyTheYoung;
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
            different moods. Whether it's peaceful, uplifting, energetic, dramatic or epic, it's always passionate. "I
            get really excited when I notice that my mood changes when I play a certain piece."</p>
        <p>'Landslide' is Christel's second album. "I enthusiastically started writing new compositions for a new album.
            But I soon found myself in a difficult phase. Music is based on emotions and experiences and is always
            personal, so putting yourself out there feels very vulnerable. I felt like I wasn't worth doing this, that
            I should give up. But at the same time, giving up didn't feel right either. When I want to clear my mind I
            always take a walk in the woods near my house. There I like to listen to some music and admire the beauty in
            nature, using my imagination and fantasy. Sometimes I pretend God walks with me. During these walks I found
            new hope and inspiration. This album is about my journey through a 'fairytale forest'. My journey of
            accepting these feelings without holding myself back, but to move forward instead."
        <p>'Only the Young' is my latest release. This is an ode to my favorite musician Brandon Flowers and his song
            'Only the Young'.</p>
    </div>
</div>

<?php
/** @var ReleaseProject[] $releases */
$releases = [
    new OnlyTheYoung(),
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
