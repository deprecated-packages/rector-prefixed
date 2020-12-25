<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper5b8c9e9ebd21\Doctrine\ORM\Mapping as ORM;
use _PhpScoper5b8c9e9ebd21\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper5b8c9e9ebd21\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
