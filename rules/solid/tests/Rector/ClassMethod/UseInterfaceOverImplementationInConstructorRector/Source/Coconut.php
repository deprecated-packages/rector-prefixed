<?php

declare (strict_types=1);
namespace Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScoper006a73f0e455\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
