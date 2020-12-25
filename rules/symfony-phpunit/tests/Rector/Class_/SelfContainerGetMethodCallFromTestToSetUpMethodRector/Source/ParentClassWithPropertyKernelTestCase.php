<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector\Source;

use _PhpScoper5edc98a7cce2\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
abstract class ParentClassWithPropertyKernelTestCase extends \_PhpScoper5edc98a7cce2\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    protected $itemRepository;
}
