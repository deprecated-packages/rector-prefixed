<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScopera143bcca66cb\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScopera143bcca66cb\Nette\Application\Routers\Route
    {
        return new \_PhpScopera143bcca66cb\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
