<?php

declare (strict_types=1);
namespace PHPStan\Rules\Variables;

use PhpParser\Node;
use PhpParser\Node\Expr\Clone_;
use PhpParser\Node\Expr\Variable;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Clone_>
 */
class VariableCloningRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Clone_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->expr, 'Cloning object of an unknown class %s.', static function (\PHPStan\Type\Type $type) : bool {
            return $type->isCloneable()->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if ($type->isCloneable()->yes()) {
            return [];
        }
        if ($node->expr instanceof \PhpParser\Node\Expr\Variable && \is_string($node->expr->name)) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot clone non-object variable $%s of type %s.', $node->expr->name, $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot clone %s.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
    }
}
