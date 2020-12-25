<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperbf340cb0be9d\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperbf340cb0be9d\Nette\Application\Routers\Route
    {
        return new \_PhpScoperbf340cb0be9d\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
