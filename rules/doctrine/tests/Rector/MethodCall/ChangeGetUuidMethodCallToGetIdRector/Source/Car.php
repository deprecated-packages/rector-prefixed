<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper267b3276efc2\Doctrine\ORM\Mapping as ORM;
use _PhpScoper267b3276efc2\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper267b3276efc2\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
