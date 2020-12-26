<?php

declare (strict_types=1);
namespace Rector\SymfonyPHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToSetUpMethodRector\Source;

use RectorPrefix2020DecSat\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
abstract class ParentClassWithPropertyKernelTestCase extends \RectorPrefix2020DecSat\Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    protected $itemRepository;
}
