<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoper0a2ac50786fa\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoper0a2ac50786fa\Nette\Application\Routers\Route
    {
        return new \_PhpScoper0a2ac50786fa\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
