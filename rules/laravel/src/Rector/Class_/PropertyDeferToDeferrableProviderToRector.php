<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\Class_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.8/upgrade#deferred-service-providers
 *
 * @see \Rector\Laravel\Tests\Rector\Class_\PropertyDeferToDeferrableProviderToRector\PropertyDeferToDeferrableProviderToRectorTest
 */
final class PropertyDeferToDeferrableProviderToRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change deprecated $defer = true; to Illuminate\\Contracts\\Support\\DeferrableProvider interface', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Support\ServiceProvider;

final class SomeServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

final class SomeServiceProvider extends ServiceProvider implements DeferrableProvider
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Support\\ServiceProvider')) {
            return null;
        }
        $deferProperty = $this->matchDeferWithFalseProperty($node);
        if ($deferProperty === null) {
            return null;
        }
        $this->removeNode($deferProperty);
        $node->implements[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('_PhpScoper2a4e7ab1ecbc\\Illuminate\\Contracts\\Support\\DeferrableProvider');
        return $node;
    }
    private function matchDeferWithFalseProperty(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->isName($property, 'defer')) {
                continue;
            }
            $onlyProperty = $property->props[0];
            if ($onlyProperty->default === null) {
                return null;
            }
            if ($this->isTrue($onlyProperty->default)) {
                return $property;
            }
        }
        return null;
    }
}
