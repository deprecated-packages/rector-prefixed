<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Namespaces;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\GroupUse>
 */
class ExistingNamesInGroupUseRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkFunctionNameCase;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\GroupUse::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->uses as $use) {
            $error = null;
            /** @var Node\Name $name */
            $name = \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name::concat($node->prefix, $use->name, ['startLine' => $use->getLine()]);
            if ($node->type === \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT || $use->type === \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT) {
                $error = $this->checkConstant($name);
            } elseif ($node->type === \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION || $use->type === \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION) {
                $error = $this->checkFunction($name);
            } elseif ($use->type === \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Use_::TYPE_NORMAL) {
                $error = $this->checkClass($name);
            } else {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            if ($error === null) {
                continue;
            }
            $errors[] = $error;
        }
        return $errors;
    }
    private function checkConstant(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasConstant($name, null)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used constant %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        return null;
    }
    private function checkFunction(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
    {
        if (!$this->reflectionProvider->hasFunction($name, null)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used function %s not found.', (string) $name))->discoveringSymbolsTip()->line($name->getLine())->build();
        }
        if ($this->checkFunctionNameCase) {
            $functionReflection = $this->reflectionProvider->getFunction($name, null);
            $realName = $functionReflection->getName();
            $usedName = (string) $name;
            if (\strtolower($realName) === \strtolower($usedName) && $realName !== $usedName) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s used with incorrect case: %s.', $realName, $usedName))->line($name->getLine())->build();
            }
        }
        return null;
    }
    private function checkClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $name) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleError
    {
        $errors = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair((string) $name, $name)]);
        if (\count($errors) === 0) {
            return null;
        } elseif (\count($errors) === 1) {
            return $errors[0];
        }
        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
    }
}
