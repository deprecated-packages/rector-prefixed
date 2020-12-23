<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper0a2ac50786fa\Symfony\Component\Routing\Annotation\Route;
// @see https://github.com/rectorphp/rector/issues/3212#issue-603962176
final class RouteWithSpacesOnItem
{
    /**
     * @Route(
     *     path="/some-endpoint",
     *     methods={"POST"}
     * )
     */
    public function run()
    {
    }
}
