<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
