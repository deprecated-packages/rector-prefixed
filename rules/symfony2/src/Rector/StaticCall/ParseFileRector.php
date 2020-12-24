<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony2\Rector\StaticCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\StaticCall\ParseFileRector\ParseFileRectorTest
 */
final class ParseFileRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('session > use_strict_mode is true by default and can be removed', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('session > use_strict_mode: true', 'session:')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * Process Node of matched type
     *
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node->name, 'parse')) {
            return null;
        }
        if (!$this->isObjectType($node->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\Yaml\\Yaml')) {
            return null;
        }
        if (!$this->isArgumentYamlFile($node)) {
            return null;
        }
        $funcCall = $this->createFuncCall('file_get_contents', [$node->args[0]]);
        $node->args[0] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($funcCall);
        return $node;
    }
    private function isArgumentYamlFile(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        $possibleFileNode = $staticCall->args[0]->value;
        $possibleFileNodeAsString = $this->print($possibleFileNode);
        // is yml/yaml file
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($possibleFileNodeAsString, self::YAML_SUFFIX_IN_QUOTE_REGEX)) {
            return \true;
        }
        // is probably a file variable
        if (\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($possibleFileNodeAsString, self::FILE_SUFFIX_REGEX)) {
            return \true;
        }
        // try to detect current value
        $nodeScope = $possibleFileNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $nodeType = $nodeScope->getType($possibleFileNode);
        if (!$nodeType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
            return \false;
        }
        return (bool) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($nodeType->getValue(), self::YAML_SUFFIX_REGEX);
    }
}
