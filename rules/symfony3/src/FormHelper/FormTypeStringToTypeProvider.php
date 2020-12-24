<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\FormHelper;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider;
final class FormTypeStringToTypeProvider
{
    /**
     * @var array<string, string>
     */
    private const SYMFONY_CORE_NAME_TO_TYPE_MAP = ['form' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FormType', 'birthday' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\BirthdayType', 'checkbox' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType', 'collection' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CollectionType', 'country' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CountryType', 'currency' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CurrencyType', 'date' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DateType', 'datetime' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\DatetimeType', 'email' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType', 'file' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType', 'hidden' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\HiddenType', 'integer' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType', 'language' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LanguageType', 'locale' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\LocaleType', 'money' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\MoneyType', 'number' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\NumberType', 'password' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PasswordType', 'percent' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PercentType', 'radio' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RadioType', 'range' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RangeType', 'repeated' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\RepeatedType', 'search' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SearchType', 'textarea' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType', 'text' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType', 'time' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimeType', 'timezone' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TimezoneType', 'url' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\UrlType', 'button' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType', 'submit' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType', 'reset' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ResetType', 'entity' => '_PhpScoperb75b35f52b74\\Symfony\\Bridge\\Doctrine\\Form\\Type\\EntityType', 'choice' => '_PhpScoperb75b35f52b74\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType'];
    /**
     * @var array<string, string>
     */
    private $customServiceFormTypeByAlias = [];
    /**
     * @var ServiceMapProvider
     */
    private $serviceMapProvider;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Symfony\ServiceMapProvider $serviceMapProvider)
    {
        $this->serviceMapProvider = $serviceMapProvider;
    }
    public function matchClassForNameWithPrefix(string $name) : ?string
    {
        $nameToTypeMap = $this->getNameToTypeMap();
        if (\_PhpScoperb75b35f52b74\Nette\Utils\Strings::startsWith($name, 'form.type.')) {
            $name = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring($name, \strlen('form.type.'));
        }
        return $nameToTypeMap[$name] ?? null;
    }
    /**
     * @return array<string, string>
     */
    private function getNameToTypeMap() : array
    {
        $customServiceFormTypeByAlias = $this->provideCustomServiceFormTypeByAliasFromContainerXml();
        return \array_merge(self::SYMFONY_CORE_NAME_TO_TYPE_MAP, $customServiceFormTypeByAlias);
    }
    /**
     * @return array<string, string>
     */
    private function provideCustomServiceFormTypeByAliasFromContainerXml() : array
    {
        if ($this->customServiceFormTypeByAlias !== []) {
            return $this->customServiceFormTypeByAlias;
        }
        $serviceMap = $this->serviceMapProvider->provide();
        $formTypeServiceDefinitions = $serviceMap->getServicesByTag('form.type');
        foreach ($formTypeServiceDefinitions as $formTypeServiceDefinition) {
            $formTypeTag = $formTypeServiceDefinition->getTag('form.type');
            if ($formTypeTag === null) {
                continue;
            }
            $alias = $formTypeTag->getData()['alias'] ?? null;
            if (!\is_string($alias)) {
                continue;
            }
            $class = $formTypeServiceDefinition->getClass();
            if ($class === null) {
                continue;
            }
            $this->customServiceFormTypeByAlias[$alias] = $class;
        }
        return $this->customServiceFormTypeByAlias;
    }
}
