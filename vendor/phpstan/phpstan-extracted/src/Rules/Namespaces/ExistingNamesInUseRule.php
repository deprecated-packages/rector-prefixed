<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Namespaces;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleError;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Use_>
 */
class ExistingNamesInUseRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkFunctionNameCase;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->type === \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        foreach ($node->uses as $use) {
            if ($use->type !== \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
        }
        if ($node->type === \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT) {
            return $this->checkConstants($node->uses);
        }
        if ($node->type === \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION) {
            return $this->checkFunctions($node->uses);
        }
        return $this->checkClasses($node->uses);
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkConstants(array $uses) : array
    {
        $errors = [];
        foreach ($uses as $use) {
            if ($this->reflectionProvider->hasConstant($use->name, null)) {
                continue;
            }
            $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used constant %s not found.', (string) $use->name))->line($use->name->getLine())->discoveringSymbolsTip()->build();
        }
        return $errors;
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkFunctions(array $uses) : array
    {
        $errors = [];
        foreach ($uses as $use) {
            if (!$this->reflectionProvider->hasFunction($use->name, null)) {
                $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Used function %s not found.', (string) $use->name))->line($use->name->getLine())->discoveringSymbolsTip()->build();
            } elseif ($this->checkFunctionNameCase) {
                $functionReflection = $this->reflectionProvider->getFunction($use->name, null);
                $realName = $functionReflection->getName();
                $usedName = (string) $use->name;
                if (\strtolower($realName) === \strtolower($usedName) && $realName !== $usedName) {
                    $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s used with incorrect case: %s.', $realName, $usedName))->line($use->name->getLine())->build();
                }
            }
        }
        return $errors;
    }
    /**
     * @param \PhpParser\Node\Stmt\UseUse[] $uses
     * @return RuleError[]
     */
    private function checkClasses(array $uses) : array
    {
        return $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\UseUse $use) : ClassNameNodePair {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair((string) $use->name, $use->name);
        }, $uses));
    }
}
