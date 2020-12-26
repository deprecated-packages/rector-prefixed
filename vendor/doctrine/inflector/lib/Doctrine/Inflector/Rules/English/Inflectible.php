<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English;

use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(s)tatuses$'), 'RectorPrefix2020DecSat\\1\\2tatus'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(s)tatus$'), 'RectorPrefix2020DecSat\\1\\2tatus'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(c)ampus$'), 'RectorPrefix2020DecSat\\1\\2ampus'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('^(.*)(menu)s$'), 'RectorPrefix2020DecSat\\1\\2'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(quiz)zes$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(matr)ices$'), '\\1ix'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(vert|ind)ices$'), '\\1ex'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('^(ox)en'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(alias)(es)*$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(buffal|her|potat|tomat|volcan)oes$'), '\\1o'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$'), '\\1us'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([ftw]ax)es'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(analys|ax|cris|test|thes)es$'), '\\1is'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(shoe|slave)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(o)es$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('ouses$'), 'ouse'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([^a])uses$'), '\\1us'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([m|l])ice$'), '\\1ouse'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(x|ch|ss|sh)es$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(m)ovies$'), 'RectorPrefix2020DecSat\\1\\2ovie'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(s)eries$'), 'RectorPrefix2020DecSat\\1\\2eries'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([^aeiouy]|qu)ies$'), '\\1y'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([lr])ves$'), '\\1f'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(tive)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(hive)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(drive)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(dive)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(olive)s$'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([^fo])ves$'), '\\1fe'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(^analy)ses$'), '\\1sis'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(analy|diagno|^ba|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$'), 'RectorPrefix2020DecSat\\1\\2sis'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(tax)a$'), '\\1on'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(c)riteria$'), '\\1riterion'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([ti])a$'), '\\1um'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(p)eople$'), 'RectorPrefix2020DecSat\\1\\2erson'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(m)en$'), '\\1an'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(c)hildren$'), 'RectorPrefix2020DecSat\\1\\2hild'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(f)eet$'), '\\1oot'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(n)ews$'), 'RectorPrefix2020DecSat\\1\\2ews'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('eaus$'), 'eau'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('s$'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(s)tatus$'), 'RectorPrefix2020DecSat\\1\\2tatuses'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(quiz)$'), '\\1zes'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('^(ox)$'), 'RectorPrefix2020DecSat\\1\\2en'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([m|l])ouse$'), '\\1ice'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(matr|vert|ind)(ix|ex)$'), '\\1ices'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(x|ch|ss|sh)$'), '\\1es'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([^aeiouy]|qu)y$'), '\\1ies'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(hive|gulf)$'), '\\1s'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(?:([^f])fe|([lr])f)$'), 'RectorPrefix2020DecSat\\1\\2ves'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('sis$'), 'ses'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('([ti])um$'), '\\1a'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(tax)on$'), '\\1a'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(c)riterion$'), '\\1riteria'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(p)erson$'), '\\1eople'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(m)an$'), '\\1en'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(c)hild$'), '\\1hildren'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(f)oot$'), '\\1eet'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(buffal|her|potat|tomat|volcan)o$'), 'RectorPrefix2020DecSat\\1\\2oes'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$'), '\\1i'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('us$'), 'uses'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(alias)$'), '\\1es'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('(analys|ax|cris|test|thes)is$'), '\\1es'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('s$'), 's'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('^$'), ''));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('$'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('atlas'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('atlases')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('axe'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('axes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('beef'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('beefs')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('brother'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('brothers')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cafe'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cafes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('chateau'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('chateaux')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('niveau'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('niveaux')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('child'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('children')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('canvas'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('canvases')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cookie'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cookies')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('corpus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('corpuses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cow'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cows')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('criterion'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('criteria')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('curriculum'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('curricula')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('demo'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('demos')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('domino'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('dominoes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('echo'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('echoes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('foot'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('feet')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('fungus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('fungi')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('ganglion'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('ganglions')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('gas'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('gases')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('genie'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('genies')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('genus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('genera')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('goose'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('geese')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('graffito'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('graffiti')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hippopotamus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hippopotami')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hoof'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hoofs')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('human'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('humans')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('iris'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('irises')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('larva'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('larvae')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('leaf'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('leaves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('lens'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('lenses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('loaf'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('loaves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('man'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('men')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('medium'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('media')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('memorandum'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('memoranda')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('money'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('monies')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mongoose'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mongooses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('motto'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mottoes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('move'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('moves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mythos'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mythoi')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('niche'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('niches')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('nucleus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('nuclei')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('numen'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('numina')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('occiput'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('occiputs')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('octopus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('octopuses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('opus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('opuses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('ox'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('oxen')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('passerby'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('passersby')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('penis'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('penises')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('person'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('people')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('plateau'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('plateaux')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('runner-up'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('runners-up')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('safe'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('safes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('sex'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('sexes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('soliloquy'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('soliloquies')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('son-in-law'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('sons-in-law')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('syllabus'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('syllabi')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('testis'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('testes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('thief'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('thieves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('tooth'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('teeth')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('tornado'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('tornadoes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('trilby'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('trilbys')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('turf'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('turfs')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('valve'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('valves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('volcano'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('volcanoes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('abuse'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('abuses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('avalanche'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('avalanches')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('cache'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('caches')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('criterion'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('criteria')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('curve'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('curves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('emphasis'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('emphases')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('foe'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('foes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('grave'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('graves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hoax'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('hoaxes')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('medium'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('media')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('neurosis'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('neuroses')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('save'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('saves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('wave'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('waves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('oasis'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('oases')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('valve'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('valves')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('zombie'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('zombies')));
    }
}
