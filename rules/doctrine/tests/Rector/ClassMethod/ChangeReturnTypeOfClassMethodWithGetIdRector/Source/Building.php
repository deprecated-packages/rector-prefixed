<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\Source;

use RectorPrefix20210301\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Building
{
    private $id;
    public function getId() : \RectorPrefix20210301\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
