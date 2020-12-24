<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.8/upgrade#deferred-service-providers
 *
 * @see \Rector\Laravel\Tests\Rector\Class_\PropertyDeferToDeferrableProviderToRector\PropertyDeferToDeferrableProviderToRectorTest
 */
final class PropertyDeferToDeferrableProviderToRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change deprecated $defer = true; to Illuminate\\Contracts\\Support\\DeferrableProvider interface', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper0a6b37af0871\\Illuminate\\Support\\ServiceProvider')) {
            return null;
        }
        $deferProperty = $this->matchDeferWithFalseProperty($node);
        if ($deferProperty === null) {
            return null;
        }
        $this->removeNode($deferProperty);
        $node->implements[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Illuminate\\Contracts\\Support\\DeferrableProvider');
        return $node;
    }
    private function matchDeferWithFalseProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property
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
