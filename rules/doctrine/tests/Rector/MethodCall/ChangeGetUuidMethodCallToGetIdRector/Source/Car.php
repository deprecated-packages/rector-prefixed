<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper006a73f0e455\Doctrine\ORM\Mapping as ORM;
use _PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
