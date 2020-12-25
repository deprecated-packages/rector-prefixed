<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source;

use _PhpScoperbf340cb0be9d\JMS\Serializer\Annotation as Serializer;
use _PhpScoperbf340cb0be9d\Symfony\Component\Validator\Constraints as Assert;
final class AnotherPropertyClass
{
    /**
     * @Assert\Type(
     *     "bool"
     * )
     * @Assert\Type("bool")
     * @Serializer\Type("boolean")
     * @var bool
     */
    public $anotherProperty;
}
