<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScoperb75b35f52b74\Symfony\Component\Routing\Annotation\Route;
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
