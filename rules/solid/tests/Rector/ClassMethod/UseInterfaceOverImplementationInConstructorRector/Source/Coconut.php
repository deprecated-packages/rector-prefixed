<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source;

use _PhpScopere8e811afab72\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Coconut implements \_PhpScopere8e811afab72\Rector\SOLID\Tests\Rector\ClassMethod\UseInterfaceOverImplementationInConstructorRector\Source\Fruit
{
    private $id;
    public function getId() : \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
