<?php declare(strict_types=1);

namespace ChristelMusic;

use ChristelMusic\Controllers\MainController;
use ChristelMusic\Controllers\OrderController;
use Parable\Framework\Path;
use Parable\Framework\Plugins\PluginInterface;
use Parable\Routing\Router;

final class RouterPlugin implements PluginInterface
{
    public function __construct(
        protected Router            $router,
        protected Path              $path,
        protected MainController    $mainController,
        protected OrderController   $orderController,
        protected ReleaseRepository $releaseFactory,
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
        foreach($this->releaseFactory->getAllProjects() as $releaseProject) {
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
        foreach($this->releaseFactory->getAllWithAlbum() as $releaseProject) {
            $releaseAlbum = $this->releaseFactory->getAlbumForProject($releaseProject);

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