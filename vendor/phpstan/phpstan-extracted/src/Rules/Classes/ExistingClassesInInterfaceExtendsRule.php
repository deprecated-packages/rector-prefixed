<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Classes;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class ExistingClassesInInterfaceExtendsRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\_PhpScoperb75b35f52b74\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->extends));
        $currentInterfaceName = (string) $node->namespacedName;
        foreach ($node->extends as $extends) {
            $extendedInterfaceName = (string) $extends;
            if (!$this->reflectionProvider->hasClass($extendedInterfaceName)) {
                if (!$scope->isInClassExists($extendedInterfaceName)) {
                    $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends unknown interface %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($extendedInterfaceName);
                if ($reflection->isClass()) {
                    $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends class %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends trait %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                }
            }
            return $messages;
        }
        return $messages;
    }
}