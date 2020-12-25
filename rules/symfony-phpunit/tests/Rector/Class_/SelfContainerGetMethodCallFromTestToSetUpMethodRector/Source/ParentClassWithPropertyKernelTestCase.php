<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector\Source;

use _PhpScoperbf340cb0be9d\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
abstract class ParentClassWithPropertyKernelTestCase extends \_PhpScoperbf340cb0be9d\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    protected $itemRepository;
}
