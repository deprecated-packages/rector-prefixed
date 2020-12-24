<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\Source;

use _PhpScoperb75b35f52b74\Nette\Application\Routers\Route;
final class RouteFactory
{
    public static function get(string $path, string $presenterClass) : \_PhpScoperb75b35f52b74\Nette\Application\Routers\Route
    {
        return new \_PhpScoperb75b35f52b74\Nette\Application\Routers\Route($path, $presenterClass);
    }
}
