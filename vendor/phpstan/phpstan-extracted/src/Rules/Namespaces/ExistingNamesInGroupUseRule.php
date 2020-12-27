<?php

declare (strict_types=1);
namespace PHPStan\Rules\Namespaces;

use PhpParser\Node;
use PhpParser\Node\Stmt\Use_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\GroupUse>
 */
class ExistingNamesInGroupUseRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkFunctionNameCase;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\GroupUse::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->uses as $use) {
            $error = null;
            /** @var Node\Name $name */
            $name = \PhpParser\Node\Name::concat($node->prefix, $use->name, ['startLine' => $use->getLine()]);
            if ($node->type === \PhpParser\Node\Stmt\Use_::TYPE_CONSTANT || $use->type === \PhpParser\Node\Stmt\Use_::TYPE_CONSTANT) {
                $error = $this->checkConstant($name);
            } elseif ($node->type === \PhpParser\Node\Stmt\Use_::TYPE_FUNCTION || $use->type === \PhpParser\Node\Stmt\Use_::TYPE_FUNCTION) {
                $error = $this->checkFunction($name);
            } elseif ($use->type === \PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
                $error = $this->checkClass($name);
            } else {
                throw new \PHPStan\ShouldNotHappenException();
            }
            if ($error === null) {
                continue;
            }
            $errors[] = $error;
        }
        return $errors;
    }
    private function checkConstant(\PhpParser\Node\Name $name) : ?\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasConstant($name, null)) {
            return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used constant %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        return null;
    }
    private function checkFunction(\PhpParser\Node\Name $name) : ?\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasFunction($name, null)) {
            return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used function %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        if ($this->checkFunctionNameCase) {
            $functionReflection = $this->reflectionProvider->getFunction($name, null);
            $realName = $functionReflection->getName();
            $usedName = (string) $name;
            if (\strtolower($realName) === \strtolower($usedName) && $realName !== $usedName) {
                return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s used with incorrect case: %s.', $realName, $usedName))->line($name->getLine())->build();
            }
        }
        return null;
    }
    private function checkClass(\PhpParser\Node\Name $name) : ?\PHPStan\Rules\RuleError
    {
        $errors = $this->classCaseSensitivityCheck->checkClassNames([new \PHPStan\Rules\ClassNameNodePair((string) $name, $name)]);
        if (\count($errors) === 0) {
            return null;
        } elseif (\count($errors) === 1) {
            return $errors[0];
        }
        throw new \PHPStan\ShouldNotHappenException();
    }
}
