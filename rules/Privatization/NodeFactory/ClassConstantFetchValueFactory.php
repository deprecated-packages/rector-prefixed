<?php

declare (strict_types=1);
namespace Rector\Privatization\NodeFactory;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\ClassConstFetch;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\Privatization\Reflection\ClassConstantsResolver;
final class ClassConstantFetchValueFactory
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var ClassConstantsResolver
     */
    private $classConstantsResolver;
    public function __construct(\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver, \Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \Rector\Privatization\Reflection\ClassConstantsResolver $classConstantsResolver)
    {
        $this->valueResolver = $valueResolver;
        $this->nodeFactory = $nodeFactory;
        $this->classConstantsResolver = $classConstantsResolver;
    }
    /**
     * @param class-string $classWithConstants
     */
    public function create(\PhpParser\Node\Expr $expr, string $classWithConstants) : ?\PhpParser\Node\Expr\ClassConstFetch
    {
        $value = $this->valueResolver->getValue($expr);
        if ($value === null) {
            return null;
        }
        $constantNamesToValues = $this->classConstantsResolver->getClassConstantNamesToValues($classWithConstants);
        foreach ($constantNamesToValues as $constantName => $constantValue) {
            if ($constantValue !== $value) {
                continue;
            }
            return $this->nodeFactory->createClassConstFetch($classWithConstants, $constantName);
        }
        return null;
    }
}
