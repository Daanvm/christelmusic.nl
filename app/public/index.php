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
<div class="row">
    <div class="col-md-8 offset-md-2">
        <?=$release->getIntroTextAsHtml()?>
    </div>
</div>
<?php endforeach; ?>

<?php require './includes/footer.php'; ?>
