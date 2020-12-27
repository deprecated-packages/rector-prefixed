<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Testing;

use RectorPrefix20201227\PHPStan\Analyser\Analyser;
use RectorPrefix20201227\PHPStan\Analyser\Error;
use RectorPrefix20201227\PHPStan\Analyser\FileAnalyser;
use RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper;
use RectorPrefix20201227\PHPStan\Cache\Cache;
use RectorPrefix20201227\PHPStan\Dependency\DependencyResolver;
use RectorPrefix20201227\PHPStan\Dependency\ExportedNodeResolver;
use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocInheritanceResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocNodeResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\PhpDocStringResolver;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider;
use RectorPrefix20201227\PHPStan\Rules\Registry;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use PHPStan\Type\FileTypeMapper;
/**
 * @template TRule of \PHPStan\Rules\Rule
 */
abstract class RuleTestCase extends \RectorPrefix20201227\PHPStan\Testing\TestCase
{
    /** @var \PHPStan\Analyser\Analyser|null */
    private $analyser = null;
    /**
     * @return \PHPStan\Rules\Rule
     * @phpstan-return TRule
     */
    protected abstract function getRule() : \RectorPrefix20201227\PHPStan\Rules\Rule;
    protected function getTypeSpecifier() : \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier
    {
        return $this->createTypeSpecifier(new \PhpParser\PrettyPrinter\Standard(), $this->createReflectionProvider(), $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
    }
    private function getAnalyser() : \RectorPrefix20201227\PHPStan\Analyser\Analyser
    {
        if ($this->analyser === null) {
            $registry = new \RectorPrefix20201227\PHPStan\Rules\Registry([$this->getRule()]);
            $broker = $this->createBroker();
            $printer = new \PhpParser\PrettyPrinter\Standard();
            $typeSpecifier = $this->createTypeSpecifier($printer, $broker, $this->getMethodTypeSpecifyingExtensions(), $this->getStaticMethodTypeSpecifyingExtensions());
            $currentWorkingDirectory = $this->getCurrentWorkingDirectory();
            $fileHelper = new \RectorPrefix20201227\PHPStan\File\FileHelper($currentWorkingDirectory);
            $currentWorkingDirectory = $fileHelper->normalizePath($currentWorkingDirectory, '/');
            $fileHelper = new \RectorPrefix20201227\PHPStan\File\FileHelper($currentWorkingDirectory);
            $relativePathHelper = new \RectorPrefix20201227\PHPStan\File\SimpleRelativePathHelper($currentWorkingDirectory);
            $anonymousClassNameHelper = new \RectorPrefix20201227\PHPStan\Broker\AnonymousClassNameHelper($fileHelper, $relativePathHelper);
            $fileTypeMapper = new \PHPStan\Type\FileTypeMapper(new \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider\DirectReflectionProviderProvider($broker), $this->getParser(), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocStringResolver::class), self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\PhpDoc\PhpDocNodeResolver::class), $this->createMock(\RectorPrefix20201227\PHPStan\Cache\Cache::class), $anonymousClassNameHelper);
            $phpDocInheritanceResolver = new \RectorPrefix20201227\PHPStan\PhpDoc\PhpDocInheritanceResolver($fileTypeMapper);
            $nodeScopeResolver = new \RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver($broker, self::getReflectors()[0], $this->getClassReflectionExtensionRegistryProvider(), $this->getParser(), $fileTypeMapper, self::getContainer()->getByType(\RectorPrefix20201227\PHPStan\Php\PhpVersion::class), $phpDocInheritanceResolver, $fileHelper, $typeSpecifier, $this->shouldPolluteScopeWithLoopInitialAssignments(), $this->shouldPolluteCatchScopeWithTryAssignments(), $this->shouldPolluteScopeWithAlwaysIterableForeach(), [], []);
            $fileAnalyser = new \RectorPrefix20201227\PHPStan\Analyser\FileAnalyser($this->createScopeFactory($broker, $typeSpecifier), $nodeScopeResolver, $this->getParser(), new \RectorPrefix20201227\PHPStan\Dependency\DependencyResolver($fileHelper, $broker, new \RectorPrefix20201227\PHPStan\Dependency\ExportedNodeResolver($fileTypeMapper, $printer)), \true);
            $this->analyser = new \RectorPrefix20201227\PHPStan\Analyser\Analyser($fileAnalyser, $registry, $nodeScopeResolver, 50);
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
        $actualErrors = \array_map(static function (\RectorPrefix20201227\PHPStan\Analyser\Error $error) use($strictlyTypedSprintf) : string {
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
