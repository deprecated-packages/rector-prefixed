<?php

declare (strict_types=1);
namespace Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoper50d83356d739\Doctrine\ORM\Mapping as ORM;
use _PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
