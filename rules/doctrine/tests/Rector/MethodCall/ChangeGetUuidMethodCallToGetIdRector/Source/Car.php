<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\Source;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
use _PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface;
/**
 * @ORM\Entity
 */
class Car
{
    private $uuid;
    public function getUuid() : \_PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface
    {
        return $this->uuid;
    }
}
