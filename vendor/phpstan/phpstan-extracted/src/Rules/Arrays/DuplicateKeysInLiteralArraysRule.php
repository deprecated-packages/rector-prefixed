<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Arrays;

use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\LiteralArrayNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\LiteralArrayNode>
 */
class DuplicateKeysInLiteralArraysRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\LiteralArrayNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $values = [];
        $duplicateKeys = [];
        $printedValues = [];
        $valueLines = [];
        foreach ($node->getItemNodes() as $itemNode) {
            $item = $itemNode->getArrayItem();
            if ($item === null) {
                continue;
            }
            if ($item->key === null) {
                continue;
            }
            $key = $item->key;
            $keyType = $itemNode->getScope()->getType($key);
            if (!$keyType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType) {
                continue;
            }
            $printedValue = $this->printer->prettyPrintExpr($key);
            $value = $keyType->getValue();
            $printedValues[$value][] = $printedValue;
            if (!isset($valueLines[$value])) {
                $valueLines[$value] = $item->getLine();
            }
            $previousCount = \count($values);
            $values[$value] = $printedValue;
            if ($previousCount !== \count($values)) {
                continue;
            }
            $duplicateKeys[$value] = \true;
        }
        $messages = [];
        foreach (\array_keys($duplicateKeys) as $value) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Array has %d %s with value %s (%s).', \count($printedValues[$value]), \count($printedValues[$value]) === 1 ? 'duplicate key' : 'duplicate keys', \var_export($value, \true), \implode(', ', $printedValues[$value])))->line($valueLines[$value])->build();
        }
        return $messages;
    }
}
