<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use _PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\_PhpScopere8e811afab72\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
