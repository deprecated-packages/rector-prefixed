<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper0a2ac50786fa\Symfony\Component\Routing\Annotation\Route;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\TestController;
final class RouteName
{
    /**
     * @Route("/hello/", name=TestController::ROUTE_NAME)
     */
    public function run()
    {
    }
}
