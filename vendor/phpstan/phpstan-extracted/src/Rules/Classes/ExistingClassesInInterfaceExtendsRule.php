<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Classes;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck;
use RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Interface_>
 */
class ExistingClassesInInterfaceExtendsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Interface_::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (\PhpParser\Node\Name $interfaceName) : ClassNameNodePair {
            return new \RectorPrefix20201227\PHPStan\Rules\ClassNameNodePair((string) $interfaceName, $interfaceName);
        }, $node->extends));
        $currentInterfaceName = (string) $node->namespacedName;
        foreach ($node->extends as $extends) {
            $extendedInterfaceName = (string) $extends;
            if (!$this->reflectionProvider->hasClass($extendedInterfaceName)) {
                if (!$scope->isInClassExists($extendedInterfaceName)) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends unknown interface %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->discoveringSymbolsTip()->build();
                }
            } else {
                $reflection = $this->reflectionProvider->getClass($extendedInterfaceName);
                if ($reflection->isClass()) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends class %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                } elseif ($reflection->isTrait()) {
                    $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Interface %s extends trait %s.', $currentInterfaceName, $extendedInterfaceName))->nonIgnorable()->build();
                }
            }
            return $messages;
        }
        return $messages;
    }
}
