<?php

declare (strict_types=1);
namespace PHPStan\Rules\Arrays;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\LiteralArrayNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class UnpackIterableInArrayRule implements \PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->getItemNodes() as $itemNode) {
            $item = $itemNode->getArrayItem();
            if ($item === null) {
                continue;
            }
            if (!$item->unpack) {
                continue;
            }
            $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $item->value, '', static function (\PHPStan\Type\Type $type) : bool {
                return $type->isIterable()->yes();
            });
            $type = $typeResult->getType();
            if ($type instanceof \PHPStan\Type\ErrorType) {
                continue;
            }
            if ($type->isIterable()->yes()) {
                continue;
            }
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Only iterables can be unpacked, %s given.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($item->getLine())->build();
        }
        return $errors;
    }
}
