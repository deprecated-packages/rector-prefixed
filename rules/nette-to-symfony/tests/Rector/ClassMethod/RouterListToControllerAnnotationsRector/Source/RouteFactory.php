<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperfce0de0de1ce\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperfce0de0de1ce\Nette\Application\Routers\Route
    {
        return new \_PhpScoperfce0de0de1ce\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
