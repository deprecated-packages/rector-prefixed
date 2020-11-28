<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperabd03f0baf05\Doctrine\ORM\Mapping as ORM;
use _PhpScoperabd03f0baf05\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperabd03f0baf05\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
