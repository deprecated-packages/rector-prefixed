<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\InaccessibleMethod;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClosureType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
class CallCallablesRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $reportMaybes;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck $check, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $reportMaybes)
    {
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->reportMaybes = $reportMaybes;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            return [];
        }
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->name, 'Invoking callable on an unknown class %s.', static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool {
            return $type->isCallable()->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        $isCallable = $type->isCallable();
        if ($isCallable->no()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Trying to invoke %s but it\'s not a callable.', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        if ($this->reportMaybes && $isCallable->maybe()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Trying to invoke %s but it might not be a callable.', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        $parametersAcceptors = $type->getCallableParametersAcceptors($scope);
        $messages = [];
        if (\count($parametersAcceptors) === 1 && $parametersAcceptors[0] instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\InaccessibleMethod) {
            $method = $parametersAcceptors[0]->getMethod();
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s method %s() of class %s.', $method->isPrivate() ? 'private' : 'protected', $method->getName(), $method->getDeclaringClass()->getDisplayName()))->build();
        }
        $parametersAcceptor = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $parametersAcceptors);
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ClosureType) {
            $callableDescription = 'closure';
        } else {
            $callableDescription = \sprintf('callable %s', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()));
        }
        return \array_merge($messages, $this->check->check($parametersAcceptor, $scope, \false, $node, [\ucfirst($callableDescription) . ' invoked with %d parameter, %d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, %d required.', \ucfirst($callableDescription) . ' invoked with %d parameter, at least %d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, at least %d required.', \ucfirst($callableDescription) . ' invoked with %d parameter, %d-%d required.', \ucfirst($callableDescription) . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of ' . $callableDescription . ' expects %s, %s given.', 'Result of ' . $callableDescription . ' (void) is used.', 'Parameter %s of ' . $callableDescription . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to ' . $callableDescription, 'Missing parameter $%s in call to ' . $callableDescription . '.', 'Unknown parameter $%s in call to ' . $callableDescription . '.']));
    }
}
