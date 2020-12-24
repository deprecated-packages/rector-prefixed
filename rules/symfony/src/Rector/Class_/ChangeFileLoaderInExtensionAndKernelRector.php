<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\Rector\Class_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Symfony\Exception\InvalidConfigurationException;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony\Tests\Rector\Class_\ChangeFileLoaderInExtensionAndKernelRector\ChangeFileLoaderInExtensionAndKernelRectorTest
 *
 * Works best with https://github.com/migrify/config-transformer
 */
final class ChangeFileLoaderInExtensionAndKernelRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const FROM = 'from';
    /**
     * @var string
     */
    public const TO = 'to';
    /**
     * @var array<string, string>
     */
    private const FILE_LOADERS_BY_TYPE = ['xml' => '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Loader\\XmlFileLoader', 'yaml' => '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Loader\\YamlFileLoader', 'php' => '_PhpScopere8e811afab72\\Symfony\\Component\\DependencyInjection\\Loader\\PhpFileLoader'];
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change XML loader to YAML in Bundle Extension', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class SomeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../Resources/config/controller.xml');
        $loader->load(__DIR__ . '/../Resources/config/events.xml');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class SomeExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../Resources/config/controller.yaml');
        $loader->load(__DIR__ . '/../Resources/config/events.yaml');
    }
}
CODE_SAMPLE
, [self::FROM => 'xml', self::TO => 'yaml'])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isKernelOrExtensionClass($node)) {
            return null;
        }
        $this->validateConfiguration($this->from, $this->to);
        $oldFileLoaderClass = self::FILE_LOADERS_BY_TYPE[$this->from];
        $newFileLoaderClass = self::FILE_LOADERS_BY_TYPE[$this->to];
        $this->traverseNodesWithCallable((array) $node->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($oldFileLoaderClass, $newFileLoaderClass) {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
                if (!$this->isName($node->class, $oldFileLoaderClass)) {
                    return null;
                }
                $node->class = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified($newFileLoaderClass);
                return $node;
            }
            return $this->refactorLoadMethodCall($node);
        });
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->from = $configuration[self::FROM];
        $this->to = $configuration[self::TO];
    }
    private function isKernelOrExtensionClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($this->isObjectType($class, '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\DependencyInjection\\Extension')) {
            return \true;
        }
        return $this->isObjectType($class, '_PhpScopere8e811afab72\\Symfony\\Component\\HttpKernel\\Kernel');
    }
    private function validateConfiguration(string $from, string $to) : void
    {
        if (!isset(self::FILE_LOADERS_BY_TYPE[$from])) {
            $message = \sprintf('File loader "%s" format is not supported', $from);
            throw new \_PhpScopere8e811afab72\Rector\Symfony\Exception\InvalidConfigurationException($message);
        }
        if (!isset(self::FILE_LOADERS_BY_TYPE[$to])) {
            $message = \sprintf('File loader "%s" format is not supported', $to);
            throw new \_PhpScopere8e811afab72\Rector\Symfony\Exception\InvalidConfigurationException($message);
        }
    }
    private function refactorLoadMethodCall(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Symfony\\Component\\Config\\Loader\\LoaderInterface')) {
            return null;
        }
        if (!$this->isName($node->name, 'load')) {
            return null;
        }
        $this->replaceSuffix($node, $this->from, $this->to);
        return $node;
    }
    private function replaceSuffix(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, string $from, string $to) : void
    {
        // replace XML to YAML suffix in string parts
        $fileArgument = $methodCall->args[0]->value;
        $this->traverseNodesWithCallable([$fileArgument], function (\_PhpScopere8e811afab72\PhpParser\Node $node) use($from, $to) : ?Node {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $node->value = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($node->value, '#\\.' . $from . '$#', '.' . $to);
            return $node;
        });
    }
}
