<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\Source;

use _PhpScoper267b3276efc2\Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class Building
{
    private $id;
    public function getId() : \_PhpScoper267b3276efc2\Ramsey\Uuid\UuidInterface
    {
        return $this->id;
    }
}
