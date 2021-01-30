<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode;
use Rector\BetterPhpDocParser\Attributes\Attribute\AttributeTrait;
use Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class NetteCrossOriginTagNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode implements \Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface, \Rector\BetterPhpDocParser\Contract\PhpDocNode\AttributeAwareNodeInterface
{
    use AttributeTrait;
    /**
     * @var string
     */
    public const NAME = '@crossOrigin';
    public function __construct()
    {
        parent::__construct(self::NAME, new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwareGenericTagValueNode(''));
    }
    public function getShortName() : string
    {
        return self::NAME;
    }
    public function getAttributeClassName() : string
    {
        return 'Nette\\Application\\Attributes\\CrossOrigin';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return [];
    }
}
