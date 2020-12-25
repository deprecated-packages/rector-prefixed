<?php

declare (strict_types=1);
namespace Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector\Source;

final class AnotherClass
{
    public function someFunction() : \Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector\Source\AnotherClass
    {
        return $this;
    }
    public function anotherFunction() : \Rector\Defluent\Tests\Rector\MethodCall\MethodCallOnSetterMethodCallToStandaloneAssignRector\Source\AnotherClass
    {
        return $this;
    }
}
