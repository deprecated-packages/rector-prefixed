<?php

declare (strict_types=1);
namespace Rector\RectorGenerator\Provider;

use Rector\RectorGenerator\ValueObject\RectorRecipe;
use Rector\Set\ValueObject\SetList;
use RectorPrefix20201228\Symfony\Component\Console\Question\ChoiceQuestion;
use RectorPrefix20201228\Symfony\Component\Console\Question\Question;
use RectorPrefix20201228\Symfony\Component\Console\Style\SymfonyStyle;
final class RectorRecipeInteractiveProvider
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var PackageNamesProvider
     */
    private $packageNamesProvider;
    /**
     * @var NodeTypesProvider
     */
    private $nodeTypesProvider;
    /**
     * @var SetsListProvider
     */
    private $setsListProvider;
    public function __construct(\Rector\RectorGenerator\Provider\PackageNamesProvider $packageNamesProvider, \Rector\RectorGenerator\Provider\NodeTypesProvider $nodeTypesProvider, \Rector\RectorGenerator\Provider\SetsListProvider $setsListProvider)
    {
        $this->packageNamesProvider = $packageNamesProvider;
        $this->nodeTypesProvider = $nodeTypesProvider;
        $this->setsListProvider = $setsListProvider;
    }
    public function provide(\RectorPrefix20201228\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle) : \Rector\RectorGenerator\ValueObject\RectorRecipe
    {
        $this->symfonyStyle = $symfonyStyle;
        $rectorRecipe = new \Rector\RectorGenerator\ValueObject\RectorRecipe($this->askForPackageName(), $this->askForRectorName(), $this->askForNodeTypes(), $this->askForRectorDescription(), $this->getExampleCodeBefore(), $this->getExampleCodeAfter());
        $rectorRecipe->setResources($this->askForResources());
        $set = $this->askForSet();
        if ($set !== null) {
            $rectorRecipe->setSet($set);
        }
        return $rectorRecipe;
    }
    private function askForPackageName() : string
    {
        $question = new \RectorPrefix20201228\Symfony\Component\Console\Question\Question(\sprintf('Package name for which Rector should be created (e.g. <fg=yellow>%s</>)', 'Naming'));
        $question->setAutocompleterValues($this->packageNamesProvider->provide());
        $packageName = $this->symfonyStyle->askQuestion($question);
        return $packageName ?? $this->askForPackageName();
    }
    private function askForRectorName() : string
    {
        $question = \sprintf('Class name of the Rector to create (e.g. <fg=yellow>%s</>)', 'RenameMethodCallRector');
        $rectorName = $this->symfonyStyle->ask($question);
        return $rectorName ?? $this->askForRectorName();
    }
    /**
     * @return array<int, class-string>
     */
    private function askForNodeTypes() : array
    {
        $question = new \RectorPrefix20201228\Symfony\Component\Console\Question\ChoiceQuestion(\sprintf('For what Nodes should the Rector be run (e.g. <fg=yellow>%s</>)', 'Expr/MethodCall'), $this->nodeTypesProvider->provide());
        $question->setMultiselect(\true);
        $nodeTypes = $this->symfonyStyle->askQuestion($question);
        $classes = [];
        foreach ($nodeTypes as $nodeType) {
            /** @var class-string $class */
            $class = 'PhpParser\\Node\\' . $nodeType;
            $classes[] = $class;
        }
        return $classes;
    }
    private function askForRectorDescription() : string
    {
        $description = $this->symfonyStyle->ask('Short description of new Rector');
        return $description ?? $this->askForRectorDescription();
    }
    private function getExampleCodeBefore() : string
    {
        return <<<'CODE_SAMPLE'
<?php

namespace RectorPrefix20201228;

class SomeClass
{
    public function run()
    {
        $this->something();
    }
}
\class_alias('RectorPrefix20201228\\SomeClass', 'SomeClass', \false);

CODE_SAMPLE;
    }
    private function getExampleCodeAfter() : string
    {
        return <<<'CODE_SAMPLE'
<?php

namespace RectorPrefix20201228;

class SomeClass
{
    public function run()
    {
        $this->somethingElse();
    }
}
\class_alias('RectorPrefix20201228\\SomeClass', 'SomeClass', \false);

CODE_SAMPLE;
    }
    /**
     * @return array<string>
     */
    private function askForResources() : array
    {
        $resources = [];
        while (\true) {
            $question = \sprintf('Link to resource that explains why the change is needed (e.g. <fg=yellow>%s</>)', 'https://github.com/symfony/symfony/blob/704c648ba53be38ef2b0105c97c6497744fef8d8/UPGRADE-6.0.md');
            $resource = $this->symfonyStyle->ask($question);
            if ($resource === null) {
                break;
            }
            $resources[] = $resource;
        }
        return $resources;
    }
    private function askForSet() : ?string
    {
        $question = new \RectorPrefix20201228\Symfony\Component\Console\Question\Question(\sprintf('Set to which Rector should be added (e.g. <fg=yellow>%s</>)', 'SYMFONY_52'));
        $question->setAutocompleterValues($this->setsListProvider->provide());
        $setName = $this->symfonyStyle->askQuestion($question);
        if ($setName === null) {
            return null;
        }
        return \constant(\Rector\Set\ValueObject\SetList::class . $setName);
    }
}
