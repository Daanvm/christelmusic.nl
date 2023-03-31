<?php declare(strict_types=1);

namespace ChristelMusic;

use ChristelMusic\Controllers\MainController;
use ChristelMusic\Controllers\OrderController;
use ChristelMusic\Releases\Landslide;
use ChristelMusic\Releases\OnlyTheYoung;
use ChristelMusic\Releases\ReleaseItem;
use ChristelMusic\Releases\ReleaseItemAlbum;
use ChristelMusic\Releases\ReleaseProject;
use ChristelMusic\Releases\Watershed;
use Parable\Framework\Path;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Routing\Router;

final class RouterPlugin implements PluginInterface
{
    public function __construct(
        protected Router $router,
        protected Path $path,
        protected MainController $mainController,
        protected OrderController $orderController,
    ) {}

    public function run(): void
    {
        // Home
        $this->router->add(
            ['GET'],
            'index',
            '/',
            [MainController::class, 'indexAction'],
            ['template' => $this->path->getPath('src/Templates/Site/index.phtml')]
        );

        $this->addReleases();
        $this->addOrders();

    }

    private function addReleases(): void
    {
        /** @var ReleaseProject[] $releaseProjects */
        $releaseProjects = [
            new OnlyTheYoung(),
            new Landslide(),
            new Watershed(),
        ];

        foreach($releaseProjects as $releaseProject) {
            $this->router->add(
                ['GET'],
                $releaseProject->getSlug(),
                $releaseProject->getSlug(),
                fn() => $this->mainController->releaseAction($releaseProject),
                ['template' => $this->path->getPath('src/Templates/Site/release.phtml')]
            );
        }
    }

    private function addOrders(): void
    {
        /** @var ReleaseProject[] $releaseProjects */
        $releaseProjects = [
            new OnlyTheYoung(),
            new Landslide(),
            new Watershed(),
        ];

        foreach($releaseProjects as $releaseProject) {
            $findAlbum = static fn (ReleaseItem $releaseItem) => $releaseItem instanceof ReleaseItemAlbum;

            /** @var ReleaseItemAlbum|null $releaseAlbum */
            $releaseAlbum = array_filter($releaseProject->getReleaseItems(), $findAlbum)[0] ?? null;

            if ($releaseAlbum === null) {
                continue;
            }

            $this->router->add(
                ['GET'],
                $releaseProject->getSlug() . '_order',
                $releaseAlbum->getOrderUrl()->localUrl,
                fn() => $this->orderController->indexAction($releaseProject),
                ['template' => $this->path->getPath('src/Templates/Site/order.phtml')]
            );

            $this->router->add(
                ['POST'],
                $releaseProject->getSlug() . '_order_submit',
                $releaseAlbum->getOrderUrl()->localUrl,
                fn() => $this->orderController->submitAction($releaseProject),
                ['template' => $this->path->getPath('src/Templates/Site/order.phtml')]
            );
        }

        $this->router->add(
            ['GET'],
            'thanks',
            'thanks',
            [OrderController::class, 'thanksAction'],
            ['template' => $this->path->getPath('src/Templates/Site/thanks.phtml')]
        );
    }
}