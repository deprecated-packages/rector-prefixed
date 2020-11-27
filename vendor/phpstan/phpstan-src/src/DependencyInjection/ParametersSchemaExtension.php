<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement;
use _PhpScoperbd5d0c5f7638\Nette\Schema\Expect;
use _PhpScoperbd5d0c5f7638\Nette\Schema\Schema;
class ParametersSchemaExtension extends \_PhpScoperbd5d0c5f7638\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoperbd5d0c5f7638\Nette\Schema\Schema
    {
        return \_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::arrayOf(\_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::type(\_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement::class))->min(1);
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $config['__parametersSchema'] = new \_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement(\_PhpScoperbd5d0c5f7638\Nette\Schema\Schema::class);
        $builder = $this->getContainerBuilder();
        $builder->parameters['__parametersSchema'] = $this->processArgument(new \_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement('schema', [new \_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement('structure', [$config])]));
    }
    /**
     * @param Statement[] $statements
     * @return \Nette\Schema\Schema
     */
    private function processSchema(array $statements) : \_PhpScoperbd5d0c5f7638\Nette\Schema\Schema
    {
        if (\count($statements) === 0) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        $parameterSchema = null;
        foreach ($statements as $statement) {
            $processedArguments = \array_map(function ($argument) {
                return $this->processArgument($argument);
            }, $statement->arguments);
            if ($parameterSchema === null) {
                /** @var \Nette\Schema\Elements\Type|\Nette\Schema\Elements\AnyOf|\Nette\Schema\Elements\Structure $parameterSchema */
                $parameterSchema = \_PhpScoperbd5d0c5f7638\Nette\Schema\Expect::{$statement->getEntity()}(...$processedArguments);
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
        if ($argument instanceof \_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement) {
            if ($argument->entity === 'schema') {
                $arguments = [];
                foreach ($argument->arguments as $schemaArgument) {
                    if (!$schemaArgument instanceof \_PhpScoperbd5d0c5f7638\Nette\DI\Definitions\Statement) {
                        throw new \PHPStan\ShouldNotHappenException('schema() should contain another statement().');
                    }
                    $arguments[] = $schemaArgument;
                }
                if (\count($arguments) === 0) {
                    throw new \PHPStan\ShouldNotHappenException('schema() should have at least one argument.');
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
