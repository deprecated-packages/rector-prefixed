<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema;
class ParametersSchemaExtension extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::type(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement::class))->min(1);
    }
    public function loadConfiguration() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $config['__parametersSchema'] = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema::class);
        $builder = $this->getContainerBuilder();
        $builder->parameters['__parametersSchema'] = $this->processArgument(new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement('schema', [new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement('structure', [$config])]));
    }
    /**
     * @param Statement[] $statements
     * @return \Nette\Schema\Schema
     */
    private function processSchema(array $statements) : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        if (\count($statements) === 0) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $parameterSchema = null;
        foreach ($statements as $statement) {
            $processedArguments = \array_map(function ($argument) {
                return $this->processArgument($argument);
            }, $statement->arguments);
            if ($parameterSchema === null) {
                /** @var \Nette\Schema\Elements\Type|\Nette\Schema\Elements\AnyOf|\Nette\Schema\Elements\Structure $parameterSchema */
                $parameterSchema = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::{$statement->getEntity()}(...$processedArguments);
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
        if ($argument instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
            if ($argument->entity === 'schema') {
                $arguments = [];
                foreach ($argument->arguments as $schemaArgument) {
                    if (!$schemaArgument instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Definitions\Statement) {
                        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException('schema() should contain another statement().');
                    }
                    $arguments[] = $schemaArgument;
                }
                if (\count($arguments) === 0) {
                    throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException('schema() should have at least one argument.');
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
