<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Rule;

use _PhpScoperabd03f0baf05\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeFinder;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
/**
 * @see \Rector\PHPStanExtensions\Tests\Rule\ConfigurableRectorRule\ConfigurableRectorRuleTest
 */
final class ConfigurableRectorRule implements \PHPStan\Rules\Rule
{
    /**
     * @var string
     */
    public const ERROR_NO_CONFIGURED_CODE_SAMPLE = 'Configurable rules must have configure code sample';
    /**
     * @var string
     */
    public const ERROR_NOT_IMPLEMENTS_INTERFACE = 'Configurable code sample is used but "%s" interface is not implemented';
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Class_::class;
    }
    /**
     * @param Class_ $node
     * @return string[]
     */
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$this->hasRectorInClassName($node)) {
            return [];
        }
        if ($node->isAbstract()) {
            return [];
        }
        if (!$this->implementsConfigurableInterface($node)) {
            if ($this->hasConfiguredCodeSample($node)) {
                $errorMessage = \sprintf(self::ERROR_NOT_IMPLEMENTS_INTERFACE, \Rector\Core\Contract\Rector\ConfigurableRectorInterface::class);
                return [$errorMessage];
            }
            return [];
        }
        if ($this->hasConfiguredCodeSample($node)) {
            return [];
        }
        return [self::ERROR_NO_CONFIGURED_CODE_SAMPLE];
    }
    private function hasRectorInClassName(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->namespacedName === null) {
            return \false;
        }
        return \_PhpScoperabd03f0baf05\Nette\Utils\Strings::endsWith((string) $class->namespacedName, 'Rector');
    }
    private function implementsConfigurableInterface(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->namespacedName === null) {
            return \false;
        }
        $fullyQualifiedClassName = (string) $class->namespacedName;
        return \is_a($fullyQualifiedClassName, \Rector\Core\Contract\Rector\ConfigurableRectorInterface::class, \true);
    }
    private function hasConfiguredCodeSample(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        $classMethod = $class->getMethod('getRuleDefinition');
        if ($classMethod === null) {
            return \false;
        }
        if ($classMethod->stmts === null) {
            return \false;
        }
        $nodeFinder = new \PhpParser\NodeFinder();
        $nodes = $nodeFinder->find($classMethod->stmts, function (\PhpParser\Node $node) : ?New_ {
            if (!$node instanceof \PhpParser\Node\Expr\New_) {
                return null;
            }
            $className = $node->class;
            if (!$className instanceof \PhpParser\Node\Name) {
                return null;
            }
            if (\is_a($className->toString(), \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample::class, \true)) {
                return $node;
            }
            return null;
        });
        return $nodes !== [];
    }
}
