<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoper006a73f0e455\Nette\DI\Definitions\Statement;
use _PhpScoper006a73f0e455\Nette\Schema\Expect;
use _PhpScoper006a73f0e455\Nette\Schema\Schema;
class ParametersSchemaExtension extends \_PhpScoper006a73f0e455\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper006a73f0e455\Nette\Schema\Schema
    {
        return \_PhpScoper006a73f0e455\Nette\Schema\Expect::arrayOf(\_PhpScoper006a73f0e455\Nette\Schema\Expect::type(\_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement::class))->min(1);
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $config['__parametersSchema'] = new \_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement(\_PhpScoper006a73f0e455\Nette\Schema\Schema::class);
        $builder = $this->getContainerBuilder();
        $builder->parameters['__parametersSchema'] = $this->processArgument(new \_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement('schema', [new \_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement('structure', [$config])]));
    }
    /**
     * @param Statement[] $statements
     * @return \Nette\Schema\Schema
     */
    private function processSchema(array $statements) : \_PhpScoper006a73f0e455\Nette\Schema\Schema
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
                $parameterSchema = \_PhpScoper006a73f0e455\Nette\Schema\Expect::{$statement->getEntity()}(...$processedArguments);
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
        if ($argument instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement) {
            if ($argument->entity === 'schema') {
                $arguments = [];
                foreach ($argument->arguments as $schemaArgument) {
                    if (!$schemaArgument instanceof \_PhpScoper006a73f0e455\Nette\DI\Definitions\Statement) {
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
