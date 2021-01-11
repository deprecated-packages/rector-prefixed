<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\Rector\Attribute;

use PhpParser\Node;
use PhpParser\Node\Attribute;
use PhpParser\Node\Expr\ClassConstFetch;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticRectorStrings;
use Rector\SymfonyCodeQuality\NodeFactory\RouteNameClassFactory;
use Rector\SymfonyCodeQuality\ValueObject\ClassName;
use RectorPrefix20210111\Symfony\Component\Routing\Annotation\Route;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://tomasvotruba.com/blog/2020/12/21/5-new-combos-opened-by-symfony-52-and-php-80/
 *
 * @see \Rector\SymfonyCodeQuality\Tests\Rector\Attribute\ExtractAttributeRouteNameConstantsRector\ExtractAttributeRouteNameConstantsRectorTest
 */
final class ExtractAttributeRouteNameConstantsRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var RouteNameClassFactory
     */
    private $routeNameClassFactory;
    public function __construct(\Rector\SymfonyCodeQuality\NodeFactory\RouteNameClassFactory $routeNameClassFactory)
    {
        $this->routeNameClassFactory = $routeNameClassFactory;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Extract #[Route] attribute name argument from string to constant', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Routing\Annotation\Route;

class SomeClass
{
    #[Route(path: "path", name: "/name")]
    public function run()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Routing\Annotation\Route;

class SomeClass
{
    #[Route(path: "path", name: RouteName::NAME)]
    public function run()
    {
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
        return [\PhpParser\Node\Attribute::class];
    }
    /**
     * @param Attribute $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node->name, \RectorPrefix20210111\Symfony\Component\Routing\Annotation\Route::class)) {
            return null;
        }
        $collectedConstantsToValues = [];
        foreach ($node->args as $arg) {
            if (!$this->isName($arg, 'name')) {
                continue;
            }
            if ($arg->value instanceof \PhpParser\Node\Expr\ClassConstFetch) {
                continue;
            }
            $argumentValue = $this->getValue($arg->value);
            if (!\is_string($argumentValue)) {
                continue;
            }
            $constantName = \Rector\Core\Util\StaticRectorStrings::camelCaseToConstant($argumentValue);
            $arg->value = $this->createClassConstFetch(\Rector\SymfonyCodeQuality\ValueObject\ClassName::ROUTE_CLASS_NAME, $constantName);
            $collectedConstantsToValues[$constantName] = $argumentValue;
        }
        if ($collectedConstantsToValues === []) {
            return null;
        }
        $namespace = $this->routeNameClassFactory->create($collectedConstantsToValues);
        $this->printNodesToFilePath([$namespace], 'src/ValueObject/Routing/RouteName.php');
        return $node;
    }
}
