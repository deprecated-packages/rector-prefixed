<?php

declare (strict_types=1);
namespace Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScoper50d83356d739\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
