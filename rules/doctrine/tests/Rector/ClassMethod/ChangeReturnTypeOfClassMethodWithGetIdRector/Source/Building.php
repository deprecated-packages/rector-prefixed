<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\Source;

use _PhpScoperbf340cb0be9d\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Building
{
    private $id;
    public function getId() : \_PhpScoperbf340cb0be9d\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
