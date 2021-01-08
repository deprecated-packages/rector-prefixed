<?php

declare (strict_types=1);
namespace Rector\Privatization\Tests\Rector\ClassMethod\PrivatizeFinalClassMethodRector\Source;

trait MethodSomeTrait
{
    protected abstract function configureRoutes();
    public function run()
    {
        $this->configureRoutes();
    }
}
