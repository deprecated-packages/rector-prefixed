<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineColumn;

use _PhpScopera143bcca66cb\Doctrine\ORM\Mapping as ORM;
final class FromOfficialDocs
{
    /**
     * @ORM\Column(type="integer", name="login_count", nullable=false, columnDefinition="CHAR(2) NOT NULL")
     */
    private $loginCount;
}
