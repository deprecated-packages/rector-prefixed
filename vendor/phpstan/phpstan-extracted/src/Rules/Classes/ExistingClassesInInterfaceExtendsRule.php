<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class ExistingClassesInInterfaceExtendsRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScoper0a2ac50786fa\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->extends));
        $currentInterfaceName = (string) $node->namespacedName;
        foreach ($node->extends as $extends) {
            $extendedInterfaceName = (string) $extends;
            if (!$this->reflectionProvider->hasClass($extendedInterfaceName)) {
                if (!$scope->isInClassExists($extendedInterfaceName)) {
                    $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends unknown interface %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($extendedInterfaceName);
                if ($reflection->isClass()) {
                    $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends class %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends trait %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                }
            }
            return $messages;
        }
        return $messages;
    }
}
