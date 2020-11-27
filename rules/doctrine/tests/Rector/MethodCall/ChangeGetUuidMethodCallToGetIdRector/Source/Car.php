<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper88fe6e0ad041\Doctrine\ORM\Mapping as ORM;
use _PhpScoper88fe6e0ad041\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper88fe6e0ad041\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
