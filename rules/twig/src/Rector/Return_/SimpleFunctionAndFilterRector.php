<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Twig\Rector\Return_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Covers https://twig.symfony.com/doc/1.x/deprecated.html#function
 *
 * @see \Rector\Twig\Tests\Rector\Return_\SimpleFunctionAndFilterRector\SimpleFunctionAndFilterRectorTest
 */
final class SimpleFunctionAndFilterRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_CLASSES = ['Twig_Function_Method' => 'Twig_SimpleFunction', 'Twig_Filter_Method' => 'Twig_SimpleFilter'];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Twig_Function_Method to Twig_SimpleFunction calls in Twig_Extension.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return [
            'is_mobile' => new Twig_Function_Method($this, 'isMobile'),
        ];
    }

    public function getFilters()
    {
        return [
            'is_mobile' => new Twig_Filter_Method($this, 'isMobile'),
        ];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return [
             new Twig_SimpleFunction('is_mobile', [$this, 'isMobile']),
        ];
    }

    public function getFilters()
    {
        return [
             new Twig_SimpleFilter('is_mobile', [$this, 'isMobile']),
        ];
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node->expr === null) {
            return null;
        }
        $classLike = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        if (!$this->isObjectType($classLike, 'Twig_Extension')) {
            return null;
        }
        $methodName = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if (!\in_array($methodName, ['getFunctions', 'getFilters'], \true)) {
            return null;
        }
        $this->traverseNodesWithCallable($node->expr, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?Node {
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem) {
                return null;
            }
            if (!$node->value instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_) {
                return null;
            }
            return $this->processArrayItem($node, $this->getObjectType($node->value));
        });
        return $node;
    }
    private function processArrayItem(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem $arrayItem, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $newNodeType) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem
    {
        foreach (self::OLD_TO_NEW_CLASSES as $oldClass => $newClass) {
            $oldClassObjectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($oldClass);
            if (!$oldClassObjectType->equals($newNodeType)) {
                continue;
            }
            if (!$arrayItem->key instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
                continue;
            }
            if (!$arrayItem->value instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_) {
                continue;
            }
            // match!
            $filterName = $this->getValue($arrayItem->key);
            $arrayItem->key = null;
            $arrayItem->value->class = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($newClass);
            $oldArguments = $arrayItem->value->args;
            $this->createNewArrayItem($arrayItem, $oldArguments, $filterName);
            return $arrayItem;
        }
        return $arrayItem;
    }
    /**
     * @param Arg[] $oldArguments
     */
    private function createNewArrayItem(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem $arrayItem, array $oldArguments, string $filterName) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem
    {
        /** @var New_ $new */
        $new = $arrayItem->value;
        if ($oldArguments[0]->value instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_) {
            // already array, just shift it
            $new->args = \array_merge([new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($filterName))], $oldArguments);
            return $arrayItem;
        }
        // not array yet, wrap to one
        $arrayItems = [];
        foreach ($oldArguments as $oldArgument) {
            $arrayItems[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem($oldArgument->value);
        }
        $new->args[0] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($filterName));
        $new->args[1] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_($arrayItems));
        return $arrayItem;
    }
}
