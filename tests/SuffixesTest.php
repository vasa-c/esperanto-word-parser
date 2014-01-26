<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Suffixes;

/**
 * @coversDefaultClass go\ewp\Suffixes
 */
class SuffixesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::find
     */
    public function testFind()
    {
        $suffixes = new Suffixes(__DIR__.'/nstst/suffixes.txt');
        $this->assertEquals(['abcig', 'igx'], $suffixes->find('abcigigx'));
        $this->assertEquals(['abc', 'ig'], $suffixes->find('abcig'));
        $this->assertNull($suffixes->find('abc'));
        $this->assertNull($suffixes->find('igx'));
    }

    /**
     * @covers ::translate
     */
    public function testTranslate()
    {
        $suffixes = new Suffixes(__DIR__.'/nstst/suffixes.txt');
        $this->assertSame('кратность', $suffixes->translate('obl'));
        $this->assertNull($suffixes->translate('oblx'));
    }
}
