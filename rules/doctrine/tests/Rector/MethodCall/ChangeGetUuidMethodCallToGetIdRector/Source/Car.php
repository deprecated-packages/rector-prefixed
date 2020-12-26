<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use RectorPrefix2020DecSat\Doctrine\ORM\Mapping as ORM;
use RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \RectorPrefix2020DecSat\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
