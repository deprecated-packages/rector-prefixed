<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperbd5d0c5f7638\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperbd5d0c5f7638\Nette\Application\Routers\Route
    {
        return new \_PhpScoperbd5d0c5f7638\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
