<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperf18a0c41e2d2\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperf18a0c41e2d2\Nette\Application\Routers\Route
    {
        return new \_PhpScoperf18a0c41e2d2\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
