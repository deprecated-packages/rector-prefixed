<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoper88fe6e0ad041\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoper88fe6e0ad041\Nette\Application\Routers\Route
    {
        return new \_PhpScoper88fe6e0ad041\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
