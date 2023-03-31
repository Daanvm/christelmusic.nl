<?php declare(strict_types=1);

namespace ChristelMusic\Controllers;

use ChristelMusic\FormData;
use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\ReleaseItem;
use ChristelMusic\Releases\ReleaseItemAlbum;
use ChristelMusic\Releases\ReleaseProject;
use ChristelMusic\Releases\Watershed;
use Parable\GetSet\DataCollection;

final class OrderController
{
    public function __construct(protected DataCollection $dataCollection) {}

    public function indexAction(ReleaseProject $releaseProject, FormData $formData = null): void
    {
        if ($formData === null) {
            $formData = FormData::empty();
        }

        $this->dataCollection->set('viewData', [
            'releaseProject' => $releaseProject,
            'pageName' => $releaseProject->getTitle(),
            'albumReleaseItems' => $this->getAlbumReleaseItems($releaseProject),
            'activeAlbumReleaseItem' => $this->getAlbumReleaseItem($releaseProject),
            'formData' => $formData,
        ]);
    }

    public function submitAction(ReleaseProject $releaseProject): void
    {
        $data = FormData::fromPost($_POST);

        if (!$data->isValid()) {
            $this->indexAction($releaseProject, $data);
            return;
        }

        $this->sendEmail($data);

        // Redirect to success message.
        header('Location: /thanks');
        exit;
    }

    public function thanksAction(): void
    {
        $this->dataCollection->set('viewData', [
            'pageName' => 'Thanks',
        ]);
    }

    /**
     * @return ReleaseItemAlbum[]
     */
    public function getAlbumReleaseItems(ReleaseProject $releaseProject): array
    {
        /** @var ReleaseItemAlbum[] $albumReleaseItems */
        $albumReleaseItems = [
            $this->getAlbumReleaseItem((new Watershed())),
            $this->getAlbumReleaseItem((new Landslide()))
        ];

        // Put Landslide on top if that's the current album being ordered
        if ($releaseProject instanceof Landslide) {
            $albumReleaseItems = array_reverse($albumReleaseItems);
        }

        return $albumReleaseItems;
    }

    /**
     * @param ReleaseProject $releaseProject
     * @return ReleaseItem
     */
    public function getAlbumReleaseItem(ReleaseProject $releaseProject): ReleaseItem
    {
        return array_filter(
            $releaseProject->getReleaseItems(),
            static fn (ReleaseItem $releaseItem) => $releaseItem instanceof ReleaseItemAlbum
        )[0];
    }

    public function sendEmail(FormData $data): void
    {
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
Watershed quantity: " . htmlentities((string)$data->quantityWatershed) . "<br />
Landslide quantity: " . htmlentities((string)$data->quantityLandslide) . "<br />
<br />        
Groetjes,<br />
Je websitebouwer<br />
";

        $iftttKey = getenv('IFTTT_KEY');
        $mailOrdersTo = getenv('MAIL_ORDERS_TO');

        $payload = [
            'value1' /* name */ => $data->name,
            'value2' /* message */ => $message,
            'value3' /* receiver */ => $mailOrdersTo,
        ];

        $ch = curl_init('https://maker.ifttt.com/trigger/watershed_ordered/with/key/' . $iftttKey);
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
    }
}