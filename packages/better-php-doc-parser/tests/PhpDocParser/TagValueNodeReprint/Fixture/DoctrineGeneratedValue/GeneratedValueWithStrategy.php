<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\Fixture\DoctrineGeneratedValue;

use RectorPrefix20201228\Doctrine\ORM\Mapping as ORM;
class GeneratedValueWithStrategy
{
    /**
     * @ORM\GeneratedValue("AUTO")
     */
    private $implicit;
    /**
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $explicitWithoutQuotes;
}
