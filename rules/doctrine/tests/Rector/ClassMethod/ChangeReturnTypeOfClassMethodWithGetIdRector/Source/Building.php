<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\Source;

use RectorPrefix2020DecSat\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Building
{
    private $id;
    public function getId() : \RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
