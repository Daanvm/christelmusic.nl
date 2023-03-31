<?php
/**
 * @var ReleaseProject $releaseProject
 */

use ChristelMusic\Releases\ReleaseItemAlbum;use ChristelMusic\Releases\ReleaseProject;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Webmozart\Assert\Assert;

require_once '../vendor/autoload.php';

Assert::isInstanceOf($releaseProject, ReleaseProject::class);

$pageName = $releaseProject->getTitle();
require './includes/header.php';

$currencies = new ISOCurrencies();
$moneyFormatter = new DecimalMoneyFormatter($currencies);
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <?=$releaseProject->getIntroTextAsHtml()?>
    </div>
</div>

<?php
foreach($releaseProject->getReleaseItems() as $releaseItem):
    $isAlreadyReleased = $releaseItem->getReleaseDate() < new DateTimeImmutable() || isset($_GET['test']);
    $isNotReleasedYet = !$isAlreadyReleased;
?>
<div class="row mt-5">
    <div class="col-md-6 order-md-2">
        <p>
            <img src="<?=$releaseItem->getImageUrl()?>" class="img-fluid"/>
        </p>
        <?php if ($releaseItem instanceof ReleaseItemAlbum && $isAlreadyReleased): ?>
            <p>
                <a class="btn btn-primary btn-<?=$releaseProject->getSlug()?>" href="<?=$releaseItem->getOrderUrl()?>" role="button">Order the CD for €<?=$moneyFormatter->format($releaseItem->getOrderPrice())?></a>
            </p>
        <?php endif; ?>
    </div>

    <div class="col-md-6 order-md-1">
        <h2>
            <?php
            $releaseType = $releaseItem instanceof ReleaseItemAlbum ? "Album" : "Single";

            if ($isNotReleasedYet) {
                echo sprintf("Coming soon: %s %s", $releaseType, $releaseItem->getTitle());
            } elseif (count($releaseItem->getStreamingInformation()) < 4) {
                echo sprintf("%s %s is available on", $releaseType, $releaseItem->getTitle());
            } else {
                echo sprintf("%s %s is available on all streaming platforms", $releaseType, $releaseItem->getTitle());
            }
            ?>
        </h2>

        <?php if ($releaseItem instanceof ReleaseItemAlbum): ?>
        <ol class="album-tracks">
            <?php foreach ($releaseItem->getTracks() as $trackTitle): ?>
            <li><?=$trackTitle?></li>
            <?php endforeach; ?>
        </ol>
        <?php endif; ?>

        <?php if ($isNotReleasedYet): ?>
            <?php if ($releaseItem->getPreSaveLink() !== null): ?>
            <p>
                <a class="btn btn-primary btn-<?=$releaseProject->getSlug()?>" href="<?=$releaseItem->getPreSaveLink()?>" target="_blank" role="button">Pre-save now!</a>
            </p>
            <?php endif; ?>
        <?php else: ?>
        <table class="get-track">
            <colgroup>
                <col/>
                <col style="width: 100px;"/>
            </colgroup>
            <tr>
                <td><i class="fab fa-spotify"></i> Spotify</td>
                <td><a class="btn btn-outline-secondary" target="_blank"
                       href="<?=$releaseItem->getStreamingInformation()->spotifyUrl?>">Listen</a>
                </td>
            </tr>
            <?php if ($releaseItem->getStreamingInformation()->appleMusicUrl !== null): ?>
            <tr>
                <td><i class="fab fa-apple"></i> Apple Music</td>
                <td><a class="btn btn-outline-secondary" target="_blank"
                       href="<?=$releaseItem->getStreamingInformation()->appleMusicUrl?>">Listen</a>
                </td>
            </tr>
            <?php endif; ?>
            <?php if ($releaseItem->getStreamingInformation()->deezerUrl !== null): ?>
            <tr>
                <td><i class="fab fa-deezer"></i> Deezer</td>
                <td><a class="btn btn-outline-secondary" target="_blank"
                       href="<?=$releaseItem->getStreamingInformation()->deezerUrl?>">Listen</a></td>
            </tr>
            <?php endif; ?>
            <?php if ($releaseItem->getStreamingInformation()->tidalUrl !== null): ?>
            <tr>
                <td><img class="icon" src="/assets/icons/brand-tidal.svg"/> Tidal</td>
                <td><a class="btn btn-outline-secondary" target="_blank"
                       href="<?=$releaseItem->getStreamingInformation()->tidalUrl?>">Listen</a></td>
            </tr>
            <?php endif; ?>
            <?php if ($releaseItem->getStreamingInformation()->amazonUrl !== null): ?>
            <tr>
                <td><i class="fab fa-amazon"></i> Amazon</td>
                <td><a class="btn btn-outline-secondary" target="_blank"
                       href="<?=$releaseItem->getStreamingInformation()->amazonUrl?>">Listen</a></td>
            </tr>
            <?php endif; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

<?php
$sheetMusics = $releaseItem->getSheetMusics();
if (count($sheetMusics) > 0 && $isAlreadyReleased):
?>
<div class="row mt-5">
    <div class="col-md-8 offset-md-2">
        <h2>Download free sheet music</h2>
    </div>
</div>
<div class="row">
    <?php foreach($sheetMusics as $sheetMusic): ?>
    <?php
    $nrOfPages = sprintf(
        "%d %s",
        $sheetMusic->getNumberOfPages(),
        $sheetMusic->getNumberOfPages() == 1 ? "page" : "pages"
    );
    ?>
    <div class="col-md-6 col-xl-4 col-sheetmusic">
        <img src="data:image/png;base64,<?=$sheetMusic->getBase64encodedPngData()?>" width="100%" /></td>
        <p>
            <span class="songname"><?=$sheetMusic->songName?></span>
            <span class="pages">(<?=$nrOfPages?>)</span>
        </p>
        <p>
            <a class="btn btn-primary btn-<?=$releaseProject->getSlug()?>" target="_blank" href="<?=$sheetMusic->getPdfUrl()?>" role="button">Download</a>
        </p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<hr />
<?php endforeach; ?>

<?php require './includes/footer.php'; ?>
