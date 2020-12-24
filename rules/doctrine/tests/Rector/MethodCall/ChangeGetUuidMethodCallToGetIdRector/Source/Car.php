<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\Mapping as ORM;
use _PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper2a4e7ab1ecbc\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
