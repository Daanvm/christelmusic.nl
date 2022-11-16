<?php
/**
 * @var ReleaseProject $releaseProject
 */

use ChristelMusic\FormData;
use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\ReleaseItem;
use ChristelMusic\Releases\ReleaseItemAlbum;
use ChristelMusic\Releases\ReleaseProject;
use ChristelMusic\Releases\Watershed;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Webmozart\Assert\Assert;

require_once '../vendor/autoload.php';

Assert::isInstanceOf($releaseProject, ReleaseProject::class);


$findAlbum = static fn (ReleaseItem $releaseItem) => $releaseItem instanceof ReleaseItemAlbum;
$watershedAlbumReleaseItem = array_filter((new Watershed())->getReleaseItems(), $findAlbum)[0];
$landslideAlbumReleaseItem = array_filter((new Landslide())->getReleaseItems(), $findAlbum)[0];

/** @var ReleaseItemAlbum[] $albumReleaseItems */
$albumReleaseItems = [$watershedAlbumReleaseItem, $landslideAlbumReleaseItem];

// Put Landslide on top if that's the current album being ordered
if ($releaseProject instanceof Landslide) {
    $albumReleaseItems = array_reverse($albumReleaseItems);
}

// Find the release item for the currently being ordered album
$activeAlbumReleaseItem = array_filter($releaseProject->getReleaseItems(), $findAlbum)[0];
Assert::isInstanceOf($activeAlbumReleaseItem, ReleaseItemAlbum::class);

if (!empty($_POST['submit'])) {
    $data = FormData::fromPost($_POST);

    if ($data->isValid()) {
        // Send email.
        $message = "
Hoi Christel!<br />
<br />
Er is een nieuwe bestelling geplaatst voor je CD:<br />
<br />        
Name: " . htmlentities($data->name) . "<br />
Email: " . htmlentities($data->email) . "<br />
Address: " . htmlentities($data->address) . "<br />
Postal Code: " . htmlentities($data->postalCode) . "<br />
City: " . htmlentities($data->city) . "<br />
Country: " . htmlentities($data->country) . "<br />
Watershed quantity: " . htmlentities($data->quantityWatershed) . "<br />
Landslide quantity: " . htmlentities($data->quantityLandslide) . "<br />
<br />        
Groetjes,<br />
Je websitebouwer<br />
";

        $payload = [
            'value1' /* name */ => $data->name,
            'value2' /* message */ => $message,
            'value3' /* unused */ => null,
        ];

        $ifttt_key = getenv('IFTTT_KEY');

        $ch = curl_init('https://maker.ifttt.com/trigger/watershed_ordered/with/key/' . $ifttt_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            echo "There was an error.";
            exit;
        }

        $responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        if ($responseCode >= 400) {
            echo "There was an error: {$responseCode}. ";
            exit;
        }

        // Redirect to success message.
        header('Location: /thanks');
        exit;
    }
} else {
    $data = FormData::empty();
}

$pageName = 'Order album ' . $activeAlbumReleaseItem->getTitle();
require './includes/header.php';

$currencies = new ISOCurrencies();
$moneyFormatter = new DecimalMoneyFormatter($currencies);

?>

<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>Order now: <?=$activeAlbumReleaseItem->getTitle()?></h1>
        <p>€<?=$moneyFormatter->format($activeAlbumReleaseItem->getOrderPrice())?> (+ shipping costs)</p>
        <p>
            <img src="<?=$activeAlbumReleaseItem->getImageUrl()?>" class="img-fluid"/>
        </p>
        <form method="post" action="<?=$activeAlbumReleaseItem->getOrderUrl()?>">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?=$data->getHtmlClass('name')?>" id="name" name="name" value="<?=htmlentities($data->name)?>" />
                    <?=$data->getHtmlFeedback('name')?>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control <?=$data->getHtmlClass('email')?>" id="email" name="email" value="<?=htmlentities($data->email)?>" />
                    <?=$data->getHtmlFeedback('email')?>
                </div>
            </div>
            <div class="form-group row">
                <label for="address" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?=$data->getHtmlClass('address')?>" id="address" name="address" value="<?=htmlentities($data->address)?>" />
                    <?=$data->getHtmlFeedback('address')?>
                </div>
            </div>
            <div class="form-group row">
                <label for="postalCode" class="col-sm-3 col-form-label">Postal code</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?=$data->getHtmlClass('postalCode')?>" id="postalCode" name="postalCode" value="<?=htmlentities($data->postalCode)?>" />
                    <?=$data->getHtmlFeedback('postalCode')?>
                </div>
            </div>
            <div class="form-group row">
                <label for="city" class="col-sm-3 col-form-label">City</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control <?=$data->getHtmlClass('city')?>" id="city" name="city" value="<?=htmlentities($data->city)?>" />
                    <?=$data->getHtmlFeedback('city')?>
                </div>
            </div>
            <div class="form-group row">
                <label for="country" class="col-sm-3 col-form-label">Country</label>
                <div class="col-sm-9">
                    <select class="form-control <?=$data->getHtmlClass('country')?>" id="country" name="country">
                        <?php
                        $countries = require('./includes/countries.php');
                        $countries['NL'] = 'The Netherlands'; // Add 'The' prefix.

                        foreach ($countries as $country) {
                            printf(
                                '<option value="%s" %s>%s</option>' . PHP_EOL,
                                $country,
                                $data->country == $country ? 'selected' : '',
                                $country
                            );
                        }
                        ?>
                    </select>
                    <?=$data->getHtmlFeedback('country')?>
                </div>
            </div>

            <?php foreach ($albumReleaseItems as $albumReleaseItem): ?>
                <?php
                $quantityId = "quantity" . $albumReleaseItem->getTitle();

                if ($albumReleaseItem->getTitle() === $activeAlbumReleaseItem->getTitle() && !$data->isSubmitted()) {
                    // Always default to 1 album of the currently active project.
                    $data->{$quantityId} = 1;
                }
                ?>
                <div class="form-group row">
                    <label for="<?=$quantityId?>" class="col-sm-3 col-form-label"><?=$albumReleaseItem->getTitle()?> qty</label>
                    <div class="col-sm-9">
                        <select class="form-control <?=$data->getHtmlClass($quantityId)?>" id="<?=$quantityId?>" name="<?=$quantityId?>">
                            <option value="0"<?=$data->{$quantityId} == 0 ? 'selected' : ''?>>No <?=$albumReleaseItem->getTitle()?> CD</option>
                            <option value="1"<?=$data->{$quantityId} == 1 ? 'selected' : ''?>>1 <?=$albumReleaseItem->getTitle()?> CD - €<?=$moneyFormatter->format($albumReleaseItem->getOrderPrice()->multiply(1))?> + shipping costs</option>
                            <option value="2"<?=$data->{$quantityId} == 2 ? 'selected' : ''?>>2 <?=$albumReleaseItem->getTitle()?> CDs - €<?=$moneyFormatter->format($albumReleaseItem->getOrderPrice()->multiply(2))?> + shipping costs</option>
                            <option value="3"<?=$data->{$quantityId} == 3 ? 'selected' : ''?>>3 <?=$albumReleaseItem->getTitle()?> CDs - €<?=$moneyFormatter->format($albumReleaseItem->getOrderPrice()->multiply(3))?> + shipping costs</option>
                        </select>
                        <?=$data->getHtmlFeedback($quantityId)?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="row">
                <div class="col-sm-12 mt-3">
                    <p>Thank you for your order! I will send you a payment link by email later.</p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" name="submit" value="submit" class="btn btn-primary btn-<?=$releaseProject->getSlug()?>">Order now</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php require './includes/footer.php'; ?>
