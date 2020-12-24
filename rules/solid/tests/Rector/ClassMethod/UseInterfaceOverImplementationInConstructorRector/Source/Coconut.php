<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \_PhpScoperb75b35f52b74\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
