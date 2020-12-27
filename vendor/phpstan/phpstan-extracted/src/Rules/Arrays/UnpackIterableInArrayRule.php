<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Arrays;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\LiteralArrayNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class UnpackIterableInArrayRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var RuleLevelHelper */
    private $ruleLevelHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper)
    {
        $this->ruleLevelHelper = $ruleLevelHelper;
    }
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Only iterables can be unpacked, %s given.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->line($item->getLine())->build();
        }
        return $errors;
    }
}
