<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper5b8c9e9ebd21\Symfony\Component\Routing\Annotation\Route;
final class RouteWithExtraNewline
{
    /**
     * @Route(
     *    path="/remove", name="route_name"
     * )
     */
    public function run()
    {
    }
}
