<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Dependency;

use _PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeContext;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory;
use _PhpScoper0a6b37af0871\PHPStan\File\FileFinder;
use _PhpScoper0a6b37af0871\PHPStan\Parser\Parser;
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
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Dependency\DependencyResolver $dependencyResolver, \_PhpScoper0a6b37af0871\PHPStan\Analyser\NodeScopeResolver $nodeScopeResolver, \_PhpScoper0a6b37af0871\PHPStan\Parser\Parser $parser, \_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeFactory $scopeFactory, \_PhpScoper0a6b37af0871\PHPStan\File\FileFinder $fileFinder)
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
            } catch (\_PhpScoper0a6b37af0871\PHPStan\Parser\ParserErrorsException $e) {
                continue;
            }
            $fileDependencies = [];
            try {
                $this->nodeScopeResolver->processNodes($parserNodes, $this->scopeFactory->create(\_PhpScoper0a6b37af0871\PHPStan\Analyser\ScopeContext::create($file)), function (\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) use($analysedFiles, &$fileDependencies) : void {
                    $dependencies = $this->dependencyResolver->resolveDependencies($node, $scope);
                    $fileDependencies = \array_merge($fileDependencies, $dependencies->getFileDependencies($scope->getFile(), $analysedFiles));
                });
            } catch (\_PhpScoper0a6b37af0871\PHPStan\AnalysedCodeException $e) {
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
