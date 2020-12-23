<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPOffice\Rector\StaticCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/PHPOffice/PhpSpreadsheet/blob/master/docs/topics/migration-from-PHPExcel.md#dedicated-class-to-manipulate-coordinates
 *
 * @see \Rector\PHPOffice\Tests\Rector\StaticCall\CellStaticToCoordinateRector\CellStaticToCoordinateRectorTest
 */
final class CellStaticToCoordinateRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const DECOUPLED_METHODS = ['absoluteCoordinate', 'absoluteReference', 'buildRange', 'columnIndexFromString', 'coordinateFromString', 'extractAllCellReferencesInRange', 'getRangeBoundaries', 'mergeRangesInCollection', 'rangeBoundaries', 'rangeDimension', 'splitRange', 'stringFromColumnIndex'];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper0a2ac50786fa\\Methods to manipulate coordinates that used to exists in PHPExcel_Cell to PhpOffice\\PhpSpreadsheet\\Cell\\Coordinate', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        \PHPExcel_Cell::stringFromColumnIndex();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isObjectType($node->class, 'PHPExcel_Cell')) {
            return null;
        }
        if (!$this->isNames($node->name, self::DECOUPLED_METHODS)) {
            return null;
        }
        $node->class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified('_PhpScoper0a2ac50786fa\\PhpOffice\\PhpSpreadsheet\\Cell\\Coordinate');
        return $node;
    }
}
