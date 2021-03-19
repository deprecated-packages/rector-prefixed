<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\PHPUnit;

use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
/**
 * @see \Rector\BetterPhpDocParser\PhpDocNodeFactory\StringMatchingPhpDocNodeFactory\PHPUnitDataDoesNotPerformAssertionDocNodeFactory
 */
final class PHPUnitDoesNotPerformAssertionTagNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
{
    /**
     * @var string
     */
    public const NAME = '@doesNotPerformAssertions';
    public function __construct()
    {
        parent::__construct(self::NAME, new \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode(''));
    }
}
