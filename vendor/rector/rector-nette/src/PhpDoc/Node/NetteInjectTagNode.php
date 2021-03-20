<?php

declare (strict_types=1);
namespace Rector\Nette\PhpDoc\Node;

use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
final class NetteInjectTagNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode
{
    /**
     * @var string
     */
    public const NAME = '@inject';
    public function __construct()
    {
        parent::__construct(self::NAME, new \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode(''));
    }
    public function getShortName() : string
    {
        return self::NAME;
    }
}
