<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony2\Rector\StaticCall;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\StaticCall\ParseFileRector\ParseFileRectorTest
 */
final class ParseFileRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/ZaY42i/1
     */
    private const YAML_SUFFIX_IN_QUOTE_REGEX = '#\\.(yml|yaml)(\'|\\")$#';
    /**
     * @var string
     * @see https://regex101.com/r/YHA05g/1
     */
    private const FILE_SUFFIX_REGEX = '#File$#';
    /**
     * @var string
     * @see https://regex101.com/r/JmNhZj/1
     */
    private const YAML_SUFFIX_REGEX = '#\\.(yml|yaml)$#';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('session > use_strict_mode is true by default and can be removed', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('session > use_strict_mode: true', 'session:')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * Process Node of matched type
     *
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node->name, 'parse')) {
            return null;
        }
        if (!$this->isObjectType($node->class, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Yaml\\Yaml')) {
            return null;
        }
        if (!$this->isArgumentYamlFile($node)) {
            return null;
        }
        $funcCall = $this->createFuncCall('file_get_contents', [$node->args[0]]);
        $node->args[0] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($funcCall);
        return $node;
    }
    private function isArgumentYamlFile(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        $possibleFileNode = $staticCall->args[0]->value;
        $possibleFileNodeAsString = $this->print($possibleFileNode);
        // is yml/yaml file
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($possibleFileNodeAsString, self::YAML_SUFFIX_IN_QUOTE_REGEX)) {
            return \true;
        }
        // is probably a file variable
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($possibleFileNodeAsString, self::FILE_SUFFIX_REGEX)) {
            return \true;
        }
        // try to detect current value
        $nodeScope = $possibleFileNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $nodeType = $nodeScope->getType($possibleFileNode);
        if (!$nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
            return \false;
        }
        return (bool) \_PhpScoperb75b35f52b74\Nette\Utils\Strings::match($nodeType->getValue(), self::YAML_SUFFIX_REGEX);
    }
}
