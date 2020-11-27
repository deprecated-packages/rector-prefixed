<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperbd5d0c5f7638\Doctrine\ORM\Mapping as ORM;
use _PhpScoperbd5d0c5f7638\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperbd5d0c5f7638\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
