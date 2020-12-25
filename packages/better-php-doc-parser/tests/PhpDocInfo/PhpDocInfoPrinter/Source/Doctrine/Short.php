<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Doctrine;

use _PhpScoper5edc98a7cce2\Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
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
