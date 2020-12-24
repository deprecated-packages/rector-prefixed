<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScoper0a6b37af0871\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \_PhpScoper0a6b37af0871\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
