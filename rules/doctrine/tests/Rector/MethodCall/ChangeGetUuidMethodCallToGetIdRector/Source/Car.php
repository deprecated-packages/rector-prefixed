<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper26e51eeacccf\Doctrine\ORM\Mapping as ORM;
use _PhpScoper26e51eeacccf\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper26e51eeacccf\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
