<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Restoration\Rector\ClassConstFetch;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\ClassConstFetch\MissingClassConstantReferenceToStringRector\MissingClassConstantReferenceToStringRectorTest
 */
final class MissingClassConstantReferenceToStringRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert missing class reference to string', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return NonExistingClass::class;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return 'NonExistingClass';
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch::class];
    }
    /**
     * @param ClassConstFetch $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node->name, 'class')) {
            return null;
        }
        $referencedClass = $this->getName($node->class);
        if ($referencedClass === null) {
            return null;
        }
        if (\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($referencedClass)) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($referencedClass);
    }
}
