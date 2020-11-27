<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\NodeScopeResolver;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\Broker\Broker;
use PHPStan\File\FileFinder;
use PHPStan\File\FileHelper;
use PHPStan\Parser\Parser;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Testing\TestCase;
use PHPStan\Type\FileTypeMapper;
use _PhpScoperbd5d0c5f7638\Tests\Dependency\Child;
use _PhpScoperbd5d0c5f7638\Tests\Dependency\GrandChild;
use _PhpScoperbd5d0c5f7638\Tests\Dependency\ParentClass;
class DependencyDumperTest extends \PHPStan\Testing\TestCase
{
    public function testDumpDependencies() : void
    {
        $container = self::getContainer();
        /** @var NodeScopeResolver $nodeScopeResolver */
        $nodeScopeResolver = $container->getByType(\PHPStan\Analyser\NodeScopeResolver::class);
        /** @var Parser $realParser */
        $realParser = $container->getByType(\PHPStan\Parser\Parser::class);
        $mockParser = $this->createMock(\PHPStan\Parser\Parser::class);
        $mockParser->method('parseFile')->willReturnCallback(static function (string $file) use($realParser) : array {
            if (\file_exists($file)) {
                return $realParser->parseFile($file);
            }
            return [];
        });
        /** @var Broker $realBroker */
        $realBroker = $container->getByType(\PHPStan\Broker\Broker::class);
        $fileHelper = new \PHPStan\File\FileHelper(__DIR__);
        $mockBroker = $this->createMock(\PHPStan\Broker\Broker::class);
        $mockBroker->method('getClass')->willReturnCallback(function (string $class) use($realBroker, $fileHelper) : ClassReflection {
            if (\in_array($class, [\_PhpScoperbd5d0c5f7638\Tests\Dependency\GrandChild::class, \_PhpScoperbd5d0c5f7638\Tests\Dependency\Child::class, \_PhpScoperbd5d0c5f7638\Tests\Dependency\ParentClass::class], \true)) {
                return $realBroker->getClass($class);
            }
            $nameParts = \explode('\\', $class);
            $shortClass = \array_pop($nameParts);
            $classReflection = $this->createMock(\PHPStan\Reflection\ClassReflection::class);
            $classReflection->method('getInterfaces')->willReturn([]);
            $classReflection->method('getTraits')->willReturn([]);
            $classReflection->method('getParentClass')->willReturn(\false);
            $classReflection->method('getFilename')->willReturn($fileHelper->normalizePath(__DIR__ . '/data/' . $shortClass . '.php'));
            return $classReflection;
        });
        $expectedDependencyTree = $this->getExpectedDependencyTree($fileHelper);
        /** @var ScopeFactory $scopeFactory */
        $scopeFactory = $container->getByType(\PHPStan\Analyser\ScopeFactory::class);
        /** @var FileFinder $fileFinder */
        $fileFinder = $container->getByType(\PHPStan\File\FileFinder::class);
        $dumper = new \PHPStan\Dependency\DependencyDumper(new \PHPStan\Dependency\DependencyResolver($fileHelper, $mockBroker, new \PHPStan\Dependency\ExportedNodeResolver(self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class), new \PhpParser\PrettyPrinter\Standard())), $nodeScopeResolver, $mockParser, $scopeFactory, $fileFinder);
        $dependencies = $dumper->dumpDependencies(\array_merge([$fileHelper->normalizePath(__DIR__ . '/data/GrandChild.php')], \array_keys($expectedDependencyTree)), static function () : void {
        }, static function () : void {
        }, null);
        $this->assertCount(\count($expectedDependencyTree), $dependencies);
        foreach ($expectedDependencyTree as $file => $files) {
            $this->assertArrayHasKey($file, $dependencies);
            $this->assertSame($files, $dependencies[$file]);
        }
    }
    /**
     * @param FileHelper $fileHelper
     * @return string[][]
     */
    private function getExpectedDependencyTree(\PHPStan\File\FileHelper $fileHelper) : array
    {
        $tree = ['Child.php' => ['GrandChild.php'], 'Parent.php' => ['GrandChild.php', 'Child.php'], 'MethodNativeReturnTypehint.php' => ['GrandChild.php'], 'MethodPhpDocReturnTypehint.php' => ['GrandChild.php'], 'ParamNativeReturnTypehint.php' => ['GrandChild.php'], 'ParamPhpDocReturnTypehint.php' => ['GrandChild.php']];
        $expectedTree = [];
        foreach ($tree as $file => $files) {
            $expectedTree[$fileHelper->normalizePath(__DIR__ . '/data/' . $file)] = \array_map(static function (string $file) use($fileHelper) : string {
                return $fileHelper->normalizePath(__DIR__ . '/data/' . $file);
            }, $files);
        }
        return $expectedTree;
    }
}
