<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony3\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony3\Tests\Rector\ClassMethod\FormTypeGetParentRector\FormTypeGetParentRectorTest
 */
final class FormTypeGetParentRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FormTypeStringToTypeProvider
     */
    private $formTypeStringToTypeProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Symfony3\FormHelper\FormTypeStringToTypeProvider $formTypeStringToTypeProvider)
    {
        $this->formTypeStringToTypeProvider = $formTypeStringToTypeProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns string Form Type references to their CONSTANT alternatives in `getParent()` and `getExtendedType()` methods in Form in Symfony', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;

class SomeType extends AbstractType
{
    public function getParent()
    {
        return 'collection';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;

class SomeType extends AbstractType
{
    public function getParent()
    {
        return \Symfony\Component\Form\Extension\Core\Type\CollectionType::class;
    }
}
CODE_SAMPLE
), new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractTypeExtension;

class SomeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'collection';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractTypeExtension;

class SomeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return \Symfony\Component\Form\Extension\Core\Type\CollectionType::class;
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isClassAndMethodMatch($node)) {
            return null;
        }
        $this->traverseNodesWithCallable((array) $node->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr === null) {
                return null;
            }
            if (!$node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $this->replaceStringWIthFormTypeClassConstIfFound($node->expr->value, $node);
            return $node;
        });
        return null;
    }
    private function isClassAndMethodMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if ($this->isInObjectType($classMethod, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\AbstractType')) {
            return $this->isName($classMethod->name, 'getParent');
        }
        if ($this->isInObjectType($classMethod, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\AbstractTypeExtension')) {
            return $this->isName($classMethod->name, 'getExtendedType');
        }
        return \false;
    }
    private function replaceStringWIthFormTypeClassConstIfFound(string $stringValue, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_ $return) : void
    {
        $formClass = $this->formTypeStringToTypeProvider->matchClassForNameWithPrefix($stringValue);
        if ($formClass === null) {
            return;
        }
        $return->expr = $this->createClassConstantReference($formClass);
    }
}
