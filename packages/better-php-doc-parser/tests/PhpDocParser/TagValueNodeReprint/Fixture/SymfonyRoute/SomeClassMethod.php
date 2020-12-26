<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\SymfonyRoute;

use RectorPrefix2020DecSat\Symfony\Component\Routing\Annotation\Route;
final class SomeClassMethod
{
    /**
     * @Route({"en"="/en"}, name="homepage")
     */
    public function run()
    {
    }
}
