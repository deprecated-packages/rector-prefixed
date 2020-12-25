<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739\Doctrine\Inflector\Rules\English;

use _PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern;
use _PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution;
use _PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation;
use _PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(s)tatuses$'), '_PhpScoper50d83356d739\\1\\2tatus'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(s)tatus$'), '_PhpScoper50d83356d739\\1\\2tatus'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(c)ampus$'), '_PhpScoper50d83356d739\\1\\2ampus'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('^(.*)(menu)s$'), '_PhpScoper50d83356d739\\1\\2'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(quiz)zes$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(matr)ices$'), '\\1ix'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(vert|ind)ices$'), '\\1ex'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('^(ox)en'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(alias)(es)*$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(buffal|her|potat|tomat|volcan)oes$'), '\\1o'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|viri?)i$'), '\\1us'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([ftw]ax)es'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(analys|ax|cris|test|thes)es$'), '\\1is'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(shoe|slave)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(o)es$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('ouses$'), 'ouse'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([^a])uses$'), '\\1us'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([m|l])ice$'), '\\1ouse'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(x|ch|ss|sh)es$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(m)ovies$'), '_PhpScoper50d83356d739\\1\\2ovie'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(s)eries$'), '_PhpScoper50d83356d739\\1\\2eries'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([^aeiouy]|qu)ies$'), '\\1y'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([lr])ves$'), '\\1f'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(tive)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(hive)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(drive)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(dive)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(olive)s$'), '\\1'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([^fo])ves$'), '\\1fe'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(^analy)ses$'), '\\1sis'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(analy|diagno|^ba|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$'), '_PhpScoper50d83356d739\\1\\2sis'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(tax)a$'), '\\1on'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(c)riteria$'), '\\1riterion'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([ti])a$'), '\\1um'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(p)eople$'), '_PhpScoper50d83356d739\\1\\2erson'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(m)en$'), '\\1an'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(c)hildren$'), '_PhpScoper50d83356d739\\1\\2hild'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(f)eet$'), '\\1oot'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(n)ews$'), '_PhpScoper50d83356d739\\1\\2ews'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('eaus$'), 'eau'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('s$'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(s)tatus$'), '_PhpScoper50d83356d739\\1\\2tatuses'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(quiz)$'), '\\1zes'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('^(ox)$'), '_PhpScoper50d83356d739\\1\\2en'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([m|l])ouse$'), '\\1ice'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(matr|vert|ind)(ix|ex)$'), '\\1ices'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(x|ch|ss|sh)$'), '\\1es'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([^aeiouy]|qu)y$'), '\\1ies'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(hive|gulf)$'), '\\1s'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(?:([^f])fe|([lr])f)$'), '_PhpScoper50d83356d739\\1\\2ves'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('sis$'), 'ses'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('([ti])um$'), '\\1a'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(tax)on$'), '\\1a'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(c)riterion$'), '\\1riteria'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(p)erson$'), '\\1eople'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(m)an$'), '\\1en'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(c)hild$'), '\\1hildren'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(f)oot$'), '\\1eet'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(buffal|her|potat|tomat|volcan)o$'), '_PhpScoper50d83356d739\\1\\2oes'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(alumn|bacill|cact|foc|fung|nucle|radi|stimul|syllab|termin|vir)us$'), '\\1i'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('us$'), 'uses'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(alias)$'), '\\1es'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('(analys|ax|cris|test|thes)is$'), '\\1es'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('s$'), 's'));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('^$'), ''));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Pattern('$'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('atlas'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('atlases')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('axe'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('axes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('beef'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('beefs')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('brother'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('brothers')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cafe'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cafes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('chateau'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('chateaux')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('niveau'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('niveaux')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('child'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('children')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('canvas'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('canvases')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cookie'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cookies')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('corpus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('corpuses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cow'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cows')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('criterion'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('criteria')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('curriculum'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('curricula')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('demo'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('demos')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('domino'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('dominoes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('echo'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('echoes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('foot'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('feet')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('fungus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('fungi')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('ganglion'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('ganglions')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('gas'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('gases')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('genie'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('genies')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('genus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('genera')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('goose'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('geese')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('graffito'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('graffiti')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hippopotamus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hippopotami')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hoof'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hoofs')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('human'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('humans')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('iris'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('irises')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('larva'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('larvae')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('leaf'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('leaves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('lens'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('lenses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('loaf'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('loaves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('man'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('men')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('medium'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('media')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('memorandum'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('memoranda')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('money'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('monies')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('mongoose'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('mongooses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('motto'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('mottoes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('move'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('moves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('mythos'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('mythoi')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('niche'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('niches')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('nucleus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('nuclei')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('numen'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('numina')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('occiput'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('occiputs')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('octopus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('octopuses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('opus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('opuses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('ox'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('oxen')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('passerby'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('passersby')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('penis'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('penises')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('person'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('people')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('plateau'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('plateaux')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('runner-up'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('runners-up')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('safe'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('safes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('sex'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('sexes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('soliloquy'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('soliloquies')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('son-in-law'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('sons-in-law')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('syllabus'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('syllabi')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('testis'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('testes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('thief'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('thieves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('tooth'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('teeth')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('tornado'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('tornadoes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('trilby'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('trilbys')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('turf'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('turfs')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('valve'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('valves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('volcano'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('volcanoes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('abuse'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('abuses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('avalanche'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('avalanches')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('cache'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('caches')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('criterion'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('criteria')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('curve'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('curves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('emphasis'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('emphases')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('foe'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('foes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('grave'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('graves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hoax'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('hoaxes')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('medium'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('media')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('neurosis'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('neuroses')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('save'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('saves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('wave'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('waves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('oasis'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('oases')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('valve'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('valves')));
        (yield new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('zombie'), new \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Word('zombies')));
    }
}
