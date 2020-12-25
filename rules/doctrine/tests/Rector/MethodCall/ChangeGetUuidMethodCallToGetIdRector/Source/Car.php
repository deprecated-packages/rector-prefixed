<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper17db12703726\Doctrine\ORM\Mapping as ORM;
use _PhpScoper17db12703726\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper17db12703726\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
