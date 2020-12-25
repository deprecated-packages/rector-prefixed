<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use _PhpScoper17db12703726\Symfony\Component\Routing\Annotation\Route;
final class SomeClassMethod
{
    /**
     * @Route({"en"="/en"}, name="homepage")
     */
    public function run()
    {
    }
}
