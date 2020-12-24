<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScopere8e811afab72\Symfony\Component\Routing\Annotation\Route;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Source\MyController;
final class RouteNameWithMethodAndClassConstant
{
    /**
     * @Route("/", methods={"GET", "POST"}, name=MyController::ROUTE_NAME)
     */
    public function run()
    {
    }
}
