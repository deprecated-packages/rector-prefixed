<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperabd03f0baf05\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperabd03f0baf05\Nette\Application\Routers\Route
    {
        return new \_PhpScoperabd03f0baf05\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
