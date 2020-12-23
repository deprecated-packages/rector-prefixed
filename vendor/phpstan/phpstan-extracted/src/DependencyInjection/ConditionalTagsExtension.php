<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\DependencyInjection;

use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierFactory;
use _PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RegistryFactory;
class ConditionalTagsExtension extends \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        $bool = \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool();
        return \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure([\_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Rules\RegistryFactory::RULE_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierFactory::METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierFactory::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool])->min(1));
    }
    public function beforeCompile() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $type => $tags) {
            $services = $builder->findByType($type);
            if (\count($services) === 0) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('No services of type "%s" found.', $type));
            }
            foreach ($services as $service) {
                foreach ($tags as $tag => $parameter) {
                    if ((bool) $parameter) {
                        $service->addTag($tag);
                        continue;
                    }
                }
            }
        }
    }
}
