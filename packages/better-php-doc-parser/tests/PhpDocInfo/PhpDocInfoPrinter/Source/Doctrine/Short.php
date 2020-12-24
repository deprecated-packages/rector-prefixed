<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine;

use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping as ORM;
use _PhpScoperb75b35f52b74\Doctrine\ORM\Mapping\UniqueConstraint;
/**
 * @ORM\Table(
 *   uniqueConstraints={
 *      @UniqueConstraint(name="content_status_unique", columns={"content_id", "site_id", "lang"})
 *     }
 * )
 */
final class Short
{
}
