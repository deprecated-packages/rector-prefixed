<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Nette;

use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class NetteCrossOriginTagNode extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode implements \Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    /**
     * @var string
     */
    public const NAME = '@crossOrigin';
    public function __construct()
    {
        parent::__construct(self::NAME, new \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode(''));
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
