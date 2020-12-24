<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoper2a4e7ab1ecbc\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoper2a4e7ab1ecbc\Nette\Application\Routers\Route
    {
        return new \_PhpScoper2a4e7ab1ecbc\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
