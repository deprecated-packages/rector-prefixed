<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use PhpParser\Node\Expr\Instanceof_;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Instanceof_>
 */
class ExistingClassInInstanceOfRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkClassCaseSensitivity)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Instanceof_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $class = $node->class;
        if (!$class instanceof \PhpParser\Node\Name) {
            return [];
        }
        $name = (string) $class;
        $lowercaseName = \strtolower($name);
        if (\in_array($lowercaseName, ['self', 'static', 'parent'], \true)) {
            if (!$scope->isInClass()) {
                return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $lowercaseName))->line($class->getLine())->build()];
            }
            return [];
        }
        if (!$this->reflectionProvider->hasClass($name)) {
            if ($scope->isInClassExists($name)) {
                return [];
            }
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s not found.', $name))->line($class->getLine())->discoveringSymbolsTip()->build()];
        } elseif ($this->checkClassCaseSensitivity) {
            return $this->classCaseSensitivityCheck->checkClassNames([new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair($name, $class)]);
        }
        return [];
    }
}
