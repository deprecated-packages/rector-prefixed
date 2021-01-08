<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use RectorPrefix20210108\Symfony\Component\Routing\Annotation\Route;
use Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\TestController;
final class RouteName
{
    /**
     * @Route("/hello/", name=TestController::ROUTE_NAME)
     */
    public function run()
    {
    }
}
