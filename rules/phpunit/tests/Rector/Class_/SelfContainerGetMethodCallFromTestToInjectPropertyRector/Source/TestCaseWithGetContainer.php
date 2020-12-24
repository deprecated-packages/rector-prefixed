<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\Tests\Rector\Class_\SelfContainerGetMethodCallFromTestToInjectPropertyRector\Source;

use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface;
abstract class TestCaseWithGetContainer extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    public function getContainer() : \_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\ContainerInterface
    {
    }
}
