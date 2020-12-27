<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Schema;
class ParametersSchemaExtension extends \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement::class))->min(1);
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $config['__parametersSchema'] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement(\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Schema::class);
        $builder = $this->getContainerBuilder();
        $builder->parameters['__parametersSchema'] = $this->processArgument(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement('schema', [new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement('structure', [$config])]));
    }
    /**
     * @param Statement[] $statements
     * @return \Nette\Schema\Schema
     */
    private function processSchema(array $statements) : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        if (\count($statements) === 0) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $parameterSchema = null;
        foreach ($statements as $statement) {
            $processedArguments = \array_map(function ($argument) {
                return $this->processArgument($argument);
            }, $statement->arguments);
            if ($parameterSchema === null) {
                /** @var \Nette\Schema\Elements\Type|\Nette\Schema\Elements\AnyOf|\Nette\Schema\Elements\Structure $parameterSchema */
                $parameterSchema = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::{$statement->getEntity()}(...$processedArguments);
            } else {
                $parameterSchema->{$statement->getEntity()}(...$processedArguments);
            }
        }
        $parameterSchema->required();
        return $parameterSchema;
    }
    /**
     * @param mixed $argument
     * @return mixed
     */
    private function processArgument($argument)
    {
        if ($argument instanceof \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
            if ($argument->entity === 'schema') {
                $arguments = [];
                foreach ($argument->arguments as $schemaArgument) {
                    if (!$schemaArgument instanceof \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException('schema() should contain another statement().');
                    }
                    $arguments[] = $schemaArgument;
                }
                if (\count($arguments) === 0) {
                    throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException('schema() should have at least one argument.');
                }
                return $this->processSchema($arguments);
            }
            return $this->processSchema([$argument]);
        } elseif (\is_array($argument)) {
            $processedArray = [];
            foreach ($argument as $key => $val) {
                $processedArray[$key] = $this->processArgument($val);
            }
            return $processedArray;
        }
        return $argument;
    }
}
