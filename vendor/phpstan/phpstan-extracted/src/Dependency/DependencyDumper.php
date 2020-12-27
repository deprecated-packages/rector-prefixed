<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Dependency;

use RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\ScopeContext;
use RectorPrefix20201227\PHPStan\Analyser\ScopeFactory;
use RectorPrefix20201227\PHPStan\File\FileFinder;
use RectorPrefix20201227\PHPStan\Parser\Parser;
class DependencyDumper
{
    /** @var DependencyResolver */
    private $dependencyResolver;
    /** @var NodeScopeResolver */
    private $nodeScopeResolver;
    /** @var Parser */
    private $parser;
    /** @var ScopeFactory */
    private $scopeFactory;
    /** @var FileFinder */
    private $fileFinder;
    public function __construct(\RectorPrefix20201227\PHPStan\Dependency\DependencyResolver $dependencyResolver, \RectorPrefix20201227\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \RectorPrefix20201227\PHPStan\Parser\Parser $parser, \RectorPrefix20201227\PHPStan\Analyser\ScopeFactory $scopeFactory, \RectorPrefix20201227\PHPStan\File\FileFinder $fileFinder)
    {
        $this->dependencyResolver = $dependencyResolver;
        $this->nodeScopeResolver = $nodeScopeResolver;
        $this->parser = $parser;
        $this->scopeFactory = $scopeFactory;
        $this->fileFinder = $fileFinder;
    }
    /**
     * @param string[] $files
     * @param callable(int $count): void $countCallback
     * @param callable(): void $progressCallback
     * @param string[]|null $analysedPaths
     * @return string[][]
     */
    public function dumpDependencies(array $files, callable $countCallback, callable $progressCallback, ?array $analysedPaths) : array
    {
        $analysedFiles = $files;
        if ($analysedPaths !== null) {
            $analysedFiles = $this->fileFinder->findFiles($analysedPaths)->getFiles();
        }
        $this->nodeScopeResolver->setAnalysedFiles($analysedFiles);
        $analysedFiles = \array_fill_keys($analysedFiles, \true);
        $dependencies = [];
        $countCallback(\count($files));
        foreach ($files as $file) {
            try {
                $parserNodes = $this->parser->parseFile($file);
            } catch (\RectorPrefix20201227\PHPStan\Parser\ParserErrorsException $e) {
                continue;
            }
            $fileDependencies = [];
            try {
                $this->nodeScopeResolver->processNodes($parserNodes, $this->scopeFactory->create(\RectorPrefix20201227\PHPStan\Analyser\ScopeContext::create($file)), function (\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) use($analysedFiles, &$fileDependencies) : void {
                    $dependencies = $this->dependencyResolver->resolveDependencies($node, $scope);
                    $fileDependencies = \array_merge($fileDependencies, $dependencies->getFileDependencies($scope->getFile(), $analysedFiles));
                });
            } catch (\RectorPrefix20201227\PHPStan\AnalysedCodeException $e) {
                // pass
            }
            foreach (\array_unique($fileDependencies) as $fileDependency) {
                $dependencies[$fileDependency][] = $file;
            }
            $progressCallback();
        }
        return $dependencies;
    }
}
