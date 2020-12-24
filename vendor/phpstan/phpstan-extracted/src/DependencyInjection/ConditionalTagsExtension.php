<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory;
use _PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RegistryFactory;
class ConditionalTagsExtension extends \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\CompilerExtension
{
    public function getConfigSchema() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Schema
    {
        $bool = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::bool();
        return \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::arrayOf(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Schema\Expect::structure([\_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::PROPERTIES_CLASS_REFLECTION_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::METHODS_CLASS_REFLECTION_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_STATIC_METHOD_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::DYNAMIC_FUNCTION_RETURN_TYPE_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Broker\BrokerFactory::OPERATOR_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Rules\RegistryFactory::RULE_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension::EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory::FUNCTION_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory::METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierFactory::STATIC_METHOD_TYPE_SPECIFYING_EXTENSION_TAG => $bool])->min(1));
    }
    public function beforeCompile() : void
    {
        /** @var mixed[] $config */
        $config = $this->config;
        $builder = $this->getContainerBuilder();
        foreach ($config as $type => $tags) {
            $services = $builder->findByType($type);
            if (\count($services) === 0) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException(\sprintf('No services of type "%s" found.', $type));
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
