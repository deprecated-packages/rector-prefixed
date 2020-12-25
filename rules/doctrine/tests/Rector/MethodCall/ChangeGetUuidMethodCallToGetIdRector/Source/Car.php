<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper567b66d83109\Doctrine\ORM\Mapping as ORM;
use _PhpScoper567b66d83109\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper567b66d83109\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
