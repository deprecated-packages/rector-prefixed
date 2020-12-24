<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper0a6b37af0871\Doctrine\ORM\Mapping as ORM;
use _PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
