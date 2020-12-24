<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
