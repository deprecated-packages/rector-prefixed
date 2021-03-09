<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use RectorPrefix20210309\Symfony\Component\Routing\Annotation\Route;
class RoutePropertyClass
{
    /**
     * @Route(
     *     "/{arg1}/{arg2}",
     *     defaults={"arg1"=null, "arg2"=""},
     *     requirements={"arg1"="\d+", "arg2"=".*"}
     * )
     */
    public function nothing() : void
    {
    }
}
