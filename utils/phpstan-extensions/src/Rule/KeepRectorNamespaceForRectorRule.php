<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\Rule;

use _PhpScoper26e51eeacccf\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
/**
 * @see \Rector\PHPStanExtensions\Tests\Rule\KeepRectorNamespaceForRectorRule\KeepRectorNamespaceForRectorRuleTest
 */
final class KeepRectorNamespaceForRectorRule implements \PHPStan\Rules\Rule
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Change namespace for "%s". It cannot be in "Rector" namespace, unless Rector rule.';
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\ClassLike::class;
    }
    /**
     * @param ClassLike $node
     * @return string[]
     */
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($this->shouldSkip($node, $scope)) {
            return [];
        }
        /** @var string $classLikeName */
        $classLikeName = (string) $node->name;
        $errorMessage = \sprintf(self::ERROR_MESSAGE, $classLikeName);
        return [$errorMessage];
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassLike $classLike, \PHPStan\Analyser\Scope $scope) : bool
    {
        $namespace = $scope->getNamespace();
        if ($namespace === null) {
            return \true;
        }
        // skip interface and tests, except tests here
        if (\_PhpScoper26e51eeacccf\Nette\Utils\Strings::match($namespace, '#\\\\(Contract|Exception|Tests)\\\\#') && !\_PhpScoper26e51eeacccf\Nette\Utils\Strings::contains($namespace, 'PHPStanExtensions')) {
            return \true;
        }
        if (!\_PhpScoper26e51eeacccf\Nette\Utils\Strings::endsWith($namespace, '\\Rector') && !\_PhpScoper26e51eeacccf\Nette\Utils\Strings::match($namespace, '#\\\\Rector\\\\#')) {
            return \true;
        }
        $name = $classLike->name;
        if ($name === null) {
            return \true;
        }
        // correct name
        $classLikeName = $name->toString();
        return (bool) \_PhpScoper26e51eeacccf\Nette\Utils\Strings::match($classLikeName, '#(Rector|Test|Trait)$#');
    }
}
