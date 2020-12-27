<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\InaccessibleMethod;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\FunctionCallParametersCheck;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ClosureType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class CallCallablesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\FunctionCallParametersCheck $check, \RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Expr) {
            return [];
        }
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->name, 'Invoking callable on an unknown class %s.', static function (\PHPStan\Type\Type $type) : bool {
            return $type->isCallable()->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isCallable = $type->isCallable();
        if ($isCallable->no()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Trying to invoke %s but it\'s not a callable.', $type->describe(\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        if ($this->reportMaybes && $isCallable->maybe()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Trying to invoke %s but it might not be a callable.', $type->describe(\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        $parametersAcceptors = $type->getCallableParametersAcceptors($scope);
        $messages = [];
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \RectorPrefix20201227\PHPStan\Reflection\InaccessibleMethod) {
            $method = $parametersAcceptors[0]->getMethod();
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s method %s() of class %s.', $method->isPrivate() ? 'private' : 'protected', $method->getName(), $method->getDeclaringClass()->getDisplayName()))->build();
        }
        $parametersAcceptor = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $parametersAcceptors);
        if ($type instanceof \PHPStan\Type\ClosureType) {
            $callableDescription = 'closure';
        } else {
            $callableDescription = \sprintf('callable %s', $type->describe(\PHPStan\Type\VerbosityLevel::value()));
        }
        return \array_merge($messages, $this->check->check($parametersAcceptor, $scope, \false, $node, [\ucfirst($callableDescription) . ' invoked with %d parameter, %d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, %d required.', \ucfirst($callableDescription) . ' invoked with %d parameter, at least %d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, at least %d required.', \ucfirst($callableDescription) . ' invoked with %d parameter, %d-%d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of ' . $callableDescription . ' expects %s, %s given.', 'Result of ' . $callableDescription . ' (void) is used.', 'Parameter %s of ' . $callableDescription . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to ' . $callableDescription, 'Missing parameter $%s in call to ' . $callableDescription . '.', 'Unknown parameter $%s in call to ' . $callableDescription . '.']));
    }
}
