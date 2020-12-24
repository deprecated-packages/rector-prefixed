<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper0a6b37af0871\Symfony\Component\Routing\Annotation\Route;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\MyController;
final class RouteNameWithMethodAndClassConstant
{
    /**
     * @Route("/", methods={"GET", "POST"}, name=MyController::ROUTE_NAME)
     */
    public function run()
    {
    }
}
