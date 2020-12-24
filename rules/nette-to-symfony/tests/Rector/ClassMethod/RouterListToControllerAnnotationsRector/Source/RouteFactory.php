<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScopere8e811afab72\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScopere8e811afab72\Nette\Application\Routers\Route
    {
        return new \_PhpScopere8e811afab72\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
