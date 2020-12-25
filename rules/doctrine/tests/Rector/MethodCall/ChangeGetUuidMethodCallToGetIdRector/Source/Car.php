<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperfce0de0de1ce\Doctrine\ORM\Mapping as ORM;
use _PhpScoperfce0de0de1ce\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperfce0de0de1ce\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
