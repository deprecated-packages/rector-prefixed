<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineColumn;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
final class FromOfficialDocs
{
    /**
     * @ORM\Column(type="integer", name="login_count", nullable=false, columnDefinition="CHAR(2) NOT NULL")
     */
    private $loginCount;
}
