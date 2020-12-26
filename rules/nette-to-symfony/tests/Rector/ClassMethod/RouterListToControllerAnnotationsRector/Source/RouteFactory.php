<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use RectorPrefix2020DecSat\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \RectorPrefix2020DecSat\Nette\Application\Routers\Route
    {
        return new \RectorPrefix2020DecSat\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
