<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\English;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern;
final class Uninflected
{
    /**
     * @return Pattern[]
     */
    public static function getSingular() : iterable
    {
        yield from self::getDefault();
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('.*ss'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('clothes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('data'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('fascia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('fuchsia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('galleria'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('mafia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('militia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pants'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('petunia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sepia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('trivia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('utopia'));
    }
    /**
     * @return Pattern[]
     */
    public static function getPlural() : iterable
    {
        yield from self::getDefault();
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('people'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('trivia'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('\\w+ware$'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('media'));
    }
    /**
     * @return Pattern[]
     */
    private static function getDefault() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('\\w+media'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('advice'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('aircraft'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('amoyese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('art'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('audio'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('baggage'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('bison'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('borghese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('bream'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('breeches'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('britches'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('buffalo'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('butter'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('cantus'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('carp'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('chassis'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('clippers'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('clothing'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('coal'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('cod'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('coitus'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('compensation'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('congoese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('contretemps'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('coreopsis'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('corps'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('cotton'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('data'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('debris'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('deer'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('diabetes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('djinn'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('education'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('eland'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('elk'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('emoji'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('equipment'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('evidence'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('faroese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('feedback'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('fish'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('flounder'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('flour'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('foochowese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('food'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('furniture'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('gallows'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('genevese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('genoese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('gilbertese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('gold'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('headquarters'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('herpes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('hijinks'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('homework'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('hottentotese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('impatience'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('information'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('innings'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('jackanapes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('jeans'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('jedi'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('kiplingese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('knowledge'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('kongoese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('leather'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('love'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('lucchese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('luggage'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('mackerel'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('Maltese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('management'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('metadata'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('mews'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('money'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('moose'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('mumps'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('music'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('nankingese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('news'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('nexus'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('niasese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('nutrition'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('offspring'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('oil'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('patience'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pekingese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('piedmontese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pincers'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pistoiese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('plankton'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pliers'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('pokemon'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('police'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('polish'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('portuguese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('proceedings'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('progress'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('rabies'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('rain'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('research'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('rhinoceros'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('rice'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('salmon'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sand'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sarawakese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('scissors'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sea[- ]bass'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('series'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('shavese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('shears'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sheep'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('siemens'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('silk'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sms'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('soap'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('social media'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('spam'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('species'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('staff'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('sugar'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('swine'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('talent'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('toothpaste'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('traffic'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('travel'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('trousers'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('trout'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('tuna'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('us'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('vermontese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('vinegar'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('weather'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('wenchowese'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('wheat'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('whiting'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('wildebeest'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('wood'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('wool'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('yengeese'));
    }
}
