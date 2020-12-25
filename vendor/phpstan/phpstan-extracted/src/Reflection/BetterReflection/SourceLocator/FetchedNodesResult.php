<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
class FetchedNodesResult
{
    /** @var array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>> */
    private $classNodes;
    /** @var array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>> */
    private $functionNodes;
    /** @var array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>> */
    private $constantNodes;
    /** @var \Roave\BetterReflection\SourceLocator\Located\LocatedSource */
    private $locatedSource;
    /**
     * @param array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>> $classNodes
     * @param array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>> $functionNodes
     * @param array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>> $constantNodes
     * @param \Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource
     */
    public function __construct(array $classNodes, array $functionNodes, array $constantNodes, \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource $locatedSource)
    {
        $this->classNodes = $classNodes;
        $this->functionNodes = $functionNodes;
        $this->constantNodes = $constantNodes;
        $this->locatedSource = $locatedSource;
    }
    /**
     * @return array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>>
     */
    public function getClassNodes() : array
    {
        return $this->classNodes;
    }
    /**
     * @return array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>>
     */
    public function getFunctionNodes() : array
    {
        return $this->functionNodes;
    }
    /**
     * @return array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>>
     */
    public function getConstantNodes() : array
    {
        return $this->constantNodes;
    }
    public function getLocatedSource() : \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource
    {
        return $this->locatedSource;
    }
}
