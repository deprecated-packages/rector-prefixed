<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(g|)ases$/i'), '\\1ás'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(japon|escoc|ingl|dinamarqu|fregu|portugu)eses$/i'), '\\1ês'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(ae|ao|oe)s$/'), 'ao'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(ãe|ão|õe)s$/'), 'ão'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(.*[^s]s)es$/i'), '\\1'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/sses$/i'), 'sse'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ns$/i'), 'm'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(r|t|f|v)is$/i'), '\\1il'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/uis$/i'), 'ul'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ois$/i'), 'ol'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/eis$/i'), 'ei'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/éis$/i'), 'el'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/([^p])ais$/i'), '\\1al'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(r|z)es$/i'), '\\1'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(á|gá)s$/i'), '\\1s'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/([^ê])s$/i'), '\\1'));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(alem|c|p)ao$/i'), '\\1aes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(irm|m)ao$/i'), '\\1aos'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ao$/i'), 'oes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(alem|c|p)ão$/i'), '\\1ães'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(irm|m)ão$/i'), '\\1ãos'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ão$/i'), 'ões'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(|g)ás$/i'), '\\1ases'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/^(japon|escoc|ingl|dinamarqu|fregu|portugu)ês$/i'), '\\1eses'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/m$/i'), 'ns'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/([^aeou])il$/i'), '\\1is'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ul$/i'), 'uis'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ol$/i'), 'ois'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/el$/i'), 'eis'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/al$/i'), 'ais'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(z|r)$/i'), '\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/(s)$/i'), '\\1'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('abdomen'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('abdomens')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('alemão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('alemães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('artesã'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('artesãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('álcool'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('álcoois')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('árvore'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('árvores')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('bencão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('bencãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('campus'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('campi')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cadáver'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cadáveres')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('capelão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('capelães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('capitão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('capitães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('chão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('chãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('charlatão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('charlatães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cidadão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cidadãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('consul'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('consules')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cristão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('cristãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('difícil'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('difíceis')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('email'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('emails')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('escrivão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('escrivães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('fóssil'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('fósseis')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('gás'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('gases')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('germens'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('germen')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('grão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('grãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('hífen'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('hífens')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('irmão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('irmãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('liquens'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('liquen')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mal'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('males')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('orfão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('orfãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('país'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('países')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('pai'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('pais')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('pão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('pães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('projétil'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('projéteis')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('réptil'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('répteis')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sacristão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sacristães')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sotão'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sotãos')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('tabelião'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('tabeliães')));
    }
}
