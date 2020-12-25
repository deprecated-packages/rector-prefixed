<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\Source;

use _PhpScoper50d83356d739\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Building
{
    private $id;
    public function getId() : \_PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
