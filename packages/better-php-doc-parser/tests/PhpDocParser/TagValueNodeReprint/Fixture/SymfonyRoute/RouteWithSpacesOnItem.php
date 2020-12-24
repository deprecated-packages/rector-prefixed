<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScopere8e811afab72\Symfony\Component\Routing\Annotation\Route;
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
