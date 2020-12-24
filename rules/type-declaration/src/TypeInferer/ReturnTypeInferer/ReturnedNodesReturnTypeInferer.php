<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VoidType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\SilentVoidResolver;
final class ReturnedNodesReturnTypeInferer extends \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @var Type[]
     */
    private $types = [];
    /**
     * @var SilentVoidResolver
     */
    private $silentVoidResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\SilentVoidResolver $silentVoidResolver)
    {
        $this->silentVoidResolver = $silentVoidResolver;
    }
    /**
     * @param ClassMethod|Closure|Function_ $functionLike
     */
    public function inferFunctionLike(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Class_|Trait_|Interface_|null $classLike */
        $classLike = $functionLike->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        if ($functionLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod && $classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $this->types = [];
        $localReturnNodes = $this->collectReturns($functionLike);
        if ($localReturnNodes === []) {
            return $this->resolveNoLocalReturnNodes($classLike, $functionLike);
        }
        $hasSilentVoid = $this->silentVoidResolver->hasSilentVoid($functionLike);
        foreach ($localReturnNodes as $localReturnNode) {
            if ($localReturnNode->expr === null) {
                $this->types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType();
                continue;
            }
            $exprType = $this->nodeTypeResolver->getStaticType($localReturnNode->expr);
            $this->types[] = $exprType;
        }
        if ($hasSilentVoid) {
            $this->types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($this->types);
    }
    public function getPriority() : int
    {
        return 1000;
    }
    /**
     * @return Return_[]
     */
    private function collectReturns(\_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : array
    {
        $returns = [];
        $this->callableNodeTraverser->traverseNodesWithCallable((array) $functionLike->getStmts(), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$returns) : ?int {
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_) {
                $this->processSwitch($node);
            }
            // skip Return_ nodes in nested functions or switch statements
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike) {
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $returns[] = $node;
            return null;
        });
        return $returns;
    }
    private function resolveNoLocalReturnNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        // void type
        if (!$this->isAbstractMethod($classLike, $functionLike)) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType();
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
    private function processSwitch(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Switch_ $switch) : void
    {
        foreach ($switch->cases as $case) {
            if ($case->cond === null) {
                return;
            }
        }
        $this->types[] = new \_PhpScoper0a6b37af0871\PHPStan\Type\VoidType();
    }
    private function isAbstractMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassLike $classLike, \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike $functionLike) : bool
    {
        if ($functionLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod && $functionLike->isAbstract()) {
            return \true;
        }
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $classLike->isAbstract();
    }
}
