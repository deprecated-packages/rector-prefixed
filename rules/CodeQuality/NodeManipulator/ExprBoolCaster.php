<?php

declare (strict_types=1);
namespace Rector\CodeQuality\NodeManipulator;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Cast\Bool_;
use PHPStan\Type\BooleanType;
use PHPStan\Type\UnionType;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\NodeTypeResolver\NodeTypeResolver;
use Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer;
use Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper;
final class ExprBoolCaster
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeUnwrapper
     */
    private $typeUnwrapper;
    /**
     * @var StaticTypeAnalyzer
     */
    private $staticTypeAnalyzer;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \Rector\PHPStanStaticTypeMapper\Utils\TypeUnwrapper $typeUnwrapper, \Rector\NodeTypeResolver\PHPStan\Type\StaticTypeAnalyzer $staticTypeAnalyzer, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->typeUnwrapper = $typeUnwrapper;
        $this->staticTypeAnalyzer = $staticTypeAnalyzer;
        $this->nodeFactory = $nodeFactory;
    }
    public function boolCastOrNullCompareIfNeeded(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr
    {
        if (!$this->nodeTypeResolver->isNullableType($expr)) {
            if (!$this->isBoolCastNeeded($expr)) {
                return $expr;
            }
            return new \PhpParser\Node\Expr\Cast\Bool_($expr);
        }
        $exprStaticType = $this->nodeTypeResolver->getStaticType($expr);
        // if we remove null type, still has to be trueable
        if ($exprStaticType instanceof \PHPStan\Type\UnionType) {
            $unionTypeWithoutNullType = $this->typeUnwrapper->removeNullTypeFromUnionType($exprStaticType);
            if ($this->staticTypeAnalyzer->isAlwaysTruableType($unionTypeWithoutNullType)) {
                return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->nodeFactory->createNull());
            }
        } elseif ($this->staticTypeAnalyzer->isAlwaysTruableType($exprStaticType)) {
            return new \PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->nodeFactory->createNull());
        }
        if (!$this->isBoolCastNeeded($expr)) {
            return $expr;
        }
        return new \PhpParser\Node\Expr\Cast\Bool_($expr);
    }
    private function isBoolCastNeeded(\PhpParser\Node\Expr $expr) : bool
    {
        if ($expr instanceof \PhpParser\Node\Expr\BooleanNot) {
            return \false;
        }
        if ($this->nodeTypeResolver->isStaticType($expr, \PHPStan\Type\BooleanType::class)) {
            return \false;
        }
        return !$expr instanceof \PhpParser\Node\Expr\BinaryOp;
    }
}
