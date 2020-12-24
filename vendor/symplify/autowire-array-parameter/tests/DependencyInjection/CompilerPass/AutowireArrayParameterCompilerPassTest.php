<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use _PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\_PhpScoperb75b35f52b74\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
