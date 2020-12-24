<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Routing\Annotation\Route;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\TestController;
final class RouteName
{
    /**
     * @Route("/hello/", name=TestController::ROUTE_NAME)
     */
    public function run()
    {
    }
}
