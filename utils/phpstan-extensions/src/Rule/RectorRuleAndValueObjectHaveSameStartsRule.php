<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Rule;

use _PhpScoperabd03f0baf05\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Rector\PHPStanExtensions\NodeAnalyzer\SymfonyConfigRectorValueObjectResolver;
use Rector\PHPStanExtensions\NodeAnalyzer\TypeAndNameAnalyzer;
use Symplify\PHPStanRules\Naming\SimpleNameResolver;
/**
 * @see \Rector\PHPStanExtensions\Tests\Rule\RectorRuleAndValueObjectHaveSameStartsRule\RectorRuleAndValueObjectHaveSameStartsRuleTest
 */
final class RectorRuleAndValueObjectHaveSameStartsRule implements \PHPStan\Rules\Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Change "%s" name to "%s", so it respects the Rector rule name';
    /**
     * @var string
     * @see https://regex101.com/r/Fk6iou/1
     */
    private const RECTOR_SUFFIX_REGEX = '#Rector$#';
    /**
     * @var SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var TypeAndNameAnalyzer
     */
    private $typeAndNameAnalyzer;
    /**
     * @var SymfonyConfigRectorValueObjectResolver
     */
    private $symfonyConfigRectorValueObjectResolver;
    public function __construct(\Symplify\PHPStanRules\Naming\SimpleNameResolver $simpleNameResolver, \Rector\PHPStanExtensions\NodeAnalyzer\TypeAndNameAnalyzer $typeAndNameAnalyzer, \Rector\PHPStanExtensions\NodeAnalyzer\SymfonyConfigRectorValueObjectResolver $symfonyConfigRectorValueObjectResolver)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->typeAndNameAnalyzer = $typeAndNameAnalyzer;
        $this->symfonyConfigRectorValueObjectResolver = $symfonyConfigRectorValueObjectResolver;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\MethodCall::class;
    }
    /**
     * @param MethodCall $node
     * @return string[]
     */
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->shouldSkip($node, $scope)) {
            return [];
        }
        $rectorShortClass = $this->resolveRectorShortClass($node);
        if ($rectorShortClass === null) {
            return [];
        }
        $valueObjectShortClass = $this->resolveValueObjectShortClass($node);
        if ($valueObjectShortClass === null) {
            return [];
        }
        $expectedValueObjectShortClass = \_PhpScoperabd03f0baf05\Nette\Utils\Strings::replace($rectorShortClass, self::RECTOR_SUFFIX_REGEX, '');
        if ($expectedValueObjectShortClass === $valueObjectShortClass) {
            return [];
        }
        $errorMessage = \sprintf(self::ERROR_MESSAGE, $valueObjectShortClass, $expectedValueObjectShortClass);
        return [$errorMessage];
    }
    private function shouldSkip(\PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : bool
    {
        return !$this->typeAndNameAnalyzer->isMethodCallTypeAndName($methodCall, $scope, '_PhpScoperabd03f0baf05\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\ServicesConfigurator', 'set');
    }
    private function resolveShortClass(string $class) : string
    {
        return (string) \_PhpScoperabd03f0baf05\Nette\Utils\Strings::after($class, '\\', -1);
    }
    private function resolveRectorShortClass(\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $setFirstArgValue = $methodCall->args[0]->value;
        if (!$setFirstArgValue instanceof \PhpParser\Node\Expr\ClassConstFetch) {
            return null;
        }
        $rectorClass = $this->simpleNameResolver->getName($setFirstArgValue->class);
        if ($rectorClass === null) {
            return null;
        }
        return $this->resolveShortClass($rectorClass);
    }
    private function resolveValueObjectShortClass(\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $valueObjectClass = $this->symfonyConfigRectorValueObjectResolver->resolveFromSetMethodCall($methodCall);
        if ($valueObjectClass === null) {
            return null;
        }
        // is it implements interface, it can have many forms
        if (\class_implements($valueObjectClass) !== []) {
            return null;
        }
        return $this->resolveShortClass($valueObjectClass);
    }
}
