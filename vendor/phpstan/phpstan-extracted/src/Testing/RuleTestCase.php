<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Testing;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\Analyser;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Error;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\FileAnalyser;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Broker\AnonymousClassNameHelper;
use _PhpScoper0a6b37af0871\PHPStan\Cache\Cache;
use _PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver;
use _PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNodeResolver;
use _PhpScoper0a6b37af0871\PHPStan\File\FileHelper;
use _PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper;
use _PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocNodeResolver;
use _PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocStringResolver;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Registry;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper;
/**
 * @template TRule of \PHPStan\Rules\Rule
 */
abstract class RuleTestCase extends \_PhpScoper0a6b37af0871\PHPStan\Testing\TestCase
{
    /** @var \PHPStan\Analyser\Analyser|null */
    private $analyser = null;
    /**
     * @return \PHPStan\Rules\Rule
     * @phpstan-return TRule
     */
    protected abstract function getRule() : \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
    protected function getTypeSpecifier() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier
    {
        return $this->createTypeSpecifier(new \_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard(), $this->createReflectionProvider(), $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
    }
    private function getAnalyser() : \_PhpScoper0a6b37af0871\PHPStan\Analyser\Analyser
    {
        if ($this->analyser === null) {
            $registry = new \_PhpScoper0a6b37af0871\PHPStan\Rules\Registry([$this->getRule()]);
            $broker = $this->createBroker();
            $printer = new \_PhpScoper0a6b37af0871\PhpParser\PrettyPrinter\Standard();
            $typeSpecifier = $this->createTypeSpecifier($printer, $broker, $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
            $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
            $fileHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper($currentWorkingDirectory);
            $currentWorkingDirectory = $fileHelper->normalizePath($currentWorkingDirectory, '/');
            $fileHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\FileHelper($currentWorkingDirectory);
            $relativePathHelper = new \_PhpScoper0a6b37af0871\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
            $anonymousClassNameHelper = new \_PhpScoper0a6b37af0871\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, $relativePathHelper);
            $fileTypeMapper = new \_PhpScoper0a6b37af0871\PHPStan\Type\FileTypeMapper(new \_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider($broker), $this->getParser(), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocStringResolver::class), self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocNodeResolver::class), $this->createMock(\_PhpScoper0a6b37af0871\PHPStan\Cache\Cache::class), $anonymousClassNameHelper);
            $phpDocInheritanceResolver = new \_PhpScoper0a6b37af0871\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
            $nodeScopeResolver = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver($broker, self::getReflectors()[0], $this->getClassReflectionExtensionRegistryProvider(), $this->getParser(), $fileTypeMapper, self::getContainer()->getByType(\_PhpScoper0a6b37af0871\PHPStan\Php\PhpVersion::class), $phpDocInheritanceResolver, $fileHelper, $typeSpecifier, $this->shouldPolluteScopeWithLoopInitialAssignments(), $this->shouldPolluteCatchScopeWithTryAssignments(), $this->shouldPolluteScopeWithAlwaysIterableForeach(), [], []);
            $fileAnalyser = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\FileAnalyser($this->createScopeFactory($broker, $typeSpecifier), $nodeScopeResolver, $this->getParser(), new \_PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver($fileHelper, $broker, new \_PhpScoper0a6b37af0871\PHPStan\Dependency\ExportedNodeResolver($fileTypeMapper, $printer)), \true);
            $this->analyser = new \_PhpScoper0a6b37af0871\PHPStan\Analyser\Analyser($fileAnalyser, $registry, $nodeScopeResolver, 50);
        }
        return $this->analyser;
    }
    /**
     * @return \PHPStan\Type\MethodTypeSpecifyingExtension[]
     */
    protected function getMethodTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @return \PHPStan\Type\StaticMethodTypeSpecifyingExtension[]
     */
    protected function getStaticMethodTypeSpecifyingExtensions() : array
    {
        return [];
    }
    /**
     * @param string[] $files
     * @param mixed[] $expectedErrors
     */
    public function analyse(array $files, array $expectedErrors) : void
    {
        $files = \array_map([$this->getFileHelper(), 'normalizePath'], $files);
        $analyserResult = $this->getAnalyser()->analyse($files);
        if (\count($analyserResult->getInternalErrors()) > 0) {
            $this->fail(\implode("\n", $analyserResult->getInternalErrors()));
        }
        $actualErrors = $analyserResult->getUnorderedErrors();
        $strictlyTypedSprintf = static function (int $line, string $message, ?string $tip) : string {
            $message = \sprintf('%02d: %s', $line, $message);
            if ($tip !== null) {
                $message .= "\n    💡 " . $tip;
            }
            return $message;
        };
        $expectedErrors = \array_map(static function (array $error) use($strictlyTypedSprintf) : string {
            if (!isset($error[0])) {
                throw new \InvalidArgumentException('Missing expected error message.');
            }
            if (!isset($error[1])) {
                throw new \InvalidArgumentException('Missing expected file line.');
            }
            return $strictlyTypedSprintf($error[1], $error[0], $error[2] ?? null);
        }, $expectedErrors);
        $actualErrors = \array_map(static function (\_PhpScoper0a6b37af0871\PHPStan\Analyser\Error $error) use($strictlyTypedSprintf) : string {
            $line = $error->getLine();
            if ($line === null) {
                return $strictlyTypedSprintf(-1, $error->getMessage(), $error->getTip());
            }
            return $strictlyTypedSprintf($line, $error->getMessage(), $error->getTip());
        }, $actualErrors);
        $this->assertSame(\implode("\n", $expectedErrors) . "\n", \implode("\n", $actualErrors) . "\n");
    }
    protected function shouldPolluteScopeWithLoopInitialAssignments() : bool
    {
        return \false;
    }
    protected function shouldPolluteCatchScopeWithTryAssignments() : bool
    {
        return \false;
    }
    protected function shouldPolluteScopeWithAlwaysIterableForeach() : bool
    {
        return \true;
    }
}
