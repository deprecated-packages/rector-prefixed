<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoper17db12703726\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoper17db12703726\Nette\Application\Routers\Route
    {
        return new \_PhpScoper17db12703726\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
