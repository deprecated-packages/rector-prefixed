<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Exception\Rector\InvalidRectorConfigurationException;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210131\Webmozart\Assert\Assert;
/**
 * @see \Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\PreferThisOrSelfMethodCallRectorTest
 */
final class PreferThisOrSelfMethodCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const TYPE_TO_PREFERENCE = 'type_to_preference';
    /**
     * @api
     * @var string
     */
    public const PREFER_SELF = self::SELF;
    /**
     * @api
     * @var string
     */
    public const PREFER_THIS = 'this';
    /**
     * @var string[]
     */
    private const ALLOWED_OPTIONS = [self::PREFER_THIS, self::PREFER_SELF];
    /**
     * @var string
     */
    private const SELF = 'self';
    /**
     * @var array<string, string>
     */
    private $typeToPreference = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes $this->... and static:: to self:: or vise versa for given types', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass extends \PHPUnit\Framework\TestCase
{
    public function run()
    {
        $this->assertEquals('a', 'a');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass extends \PHPUnit\Framework\TestCase
{
    public function run()
    {
        self::assertEquals('a', 'a');
    }
}
CODE_SAMPLE
, [self::TYPE_TO_PREFERENCE => ['PHPUnit\\Framework\\TestCase' => self::PREFER_SELF]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->typeToPreference as $type => $preference) {
            if (!$this->isMethodStaticCallOrClassMethodObjectType($node, $type)) {
                continue;
            }
            if ($preference === self::PREFER_SELF) {
                return $this->processToSelf($node);
            }
            return $this->processToThis($node);
        }
        return null;
    }
    /**
     * @param mixed[] $configuration
     */
    public function configure(array $configuration) : void
    {
        $typeToPreference = $configuration[self::TYPE_TO_PREFERENCE] ?? [];
        \RectorPrefix20210131\Webmozart\Assert\Assert::allString($typeToPreference);
        foreach ($typeToPreference as $preference) {
            $this->ensurePreferenceIsValid($preference);
        }
        $this->typeToPreference = $typeToPreference;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function processToSelf(\PhpParser\Node $node) : ?\PhpParser\Node\Expr\StaticCall
    {
        if ($node instanceof \PhpParser\Node\Expr\StaticCall && !$this->isNames($node->class, [self::SELF, 'static'])) {
            return null;
        }
        if ($node instanceof \PhpParser\Node\Expr\MethodCall && !$this->isName($node->var, 'this')) {
            return null;
        }
        $name = $this->getName($node->name);
        if ($name === null) {
            return null;
        }
        return $this->nodeFactory->createStaticCall(self::SELF, $name, $node->args);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function processToThis(\PhpParser\Node $node) : ?\PhpParser\Node\Expr\MethodCall
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->isNames($node->class, [self::SELF, 'static'])) {
            return null;
        }
        $name = $this->getName($node->name);
        if ($name === null) {
            return null;
        }
        return $this->nodeFactory->createMethodCall('this', $name, $node->args);
    }
    private function ensurePreferenceIsValid(string $preference) : void
    {
        if (\in_array($preference, self::ALLOWED_OPTIONS, \true)) {
            return;
        }
        throw new \Rector\Core\Exception\Rector\InvalidRectorConfigurationException(\sprintf('Preference configuration "%s" for "%s" is not valid. Use one of "%s"', $preference, self::class, \implode('", "', self::ALLOWED_OPTIONS)));
    }
}
