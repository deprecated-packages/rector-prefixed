<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper0a2ac50786fa\Doctrine\ORM\Mapping as ORM;
use _PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
