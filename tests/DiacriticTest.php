<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Diacritic;

/**
 * @coversDefaultClass go\ewp\Diacritic
 */
class DiacriticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::diacritic2latin
     * @covers ::latin2diacritic
     */
    public function testConvert()
    {
        $esper = 'abcĉd efgĝh ĥijĵk lmnop rsŝtu ŭvzAB CĈDEF GĜHĤI JĴKLM NOPRS ŜTUŬV Z';
        $latin = 'abccxd efggxh hxijjxk lmnop rssxtu uxvzab ccxdef ggxhhxi jjxklm noprs sxtuuxv z';
        $this->assertSame($latin, Diacritic::diacritic2latin($esper));
        $esperl = 'abcĉd efgĝh ĥijĵk lmnop rsŝtu ŭvzab cĉdef gĝhĥi jĵklm noprs ŝtuŭv z';
        $this->assertSame($esperl, Diacritic::latin2diacritic($latin));
        $this->assertSame('auxs', Diacritic::diacritic2latin('au~s'));
        $this->assertSame('aŭs', Diacritic::latin2diacritic('au~s'));
    }
}
