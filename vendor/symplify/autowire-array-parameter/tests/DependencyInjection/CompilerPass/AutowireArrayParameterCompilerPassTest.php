<?php

declare (strict_types=1);
namespace RectorPrefix20210107\Symplify\AutowireArrayParameter\Tests\DependencyInjection\CompilerPass;

use RectorPrefix20210107\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel;
use RectorPrefix20210107\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector;
use RectorPrefix20210107\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class AutowireArrayParameterCompilerPassTest extends \RectorPrefix20210107\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    public function test() : void
    {
        $this->bootKernel(\RectorPrefix20210107\Symplify\AutowireArrayParameter\Tests\HttpKernel\AutowireArrayParameterHttpKernel::class);
        /** @var SomeCollector $someCollector */
        $someCollector = $this->getService(\RectorPrefix20210107\Symplify\AutowireArrayParameter\Tests\Source\SomeCollector::class);
        $this->assertCount(2, $someCollector->getCollected());
    }
}
