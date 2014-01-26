<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Prefixes;

/**
 * @coversDefaultClass go\ewp\Prefixes
 */
class PrefixesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::find
     */
    public function testFind()
    {
        $prefixes = new Prefixes(__DIR__.'/nstst/prefixes.txt');
        $this->assertEquals(['trans', 'abc'], $prefixes->find('transabc'));
        $this->assertEquals(['tra', 'abc'], $prefixes->find('traabc'));
        $this->assertEquals(['tra', 'ns'], $prefixes->find('trans'));
        $this->assertNull($prefixes->find('tra'));
        $this->assertNull($prefixes->find('qwerty'));
    }

    /**
     * @covers ::translate
     */
    public function testTranslate()
    {
        $prefixes = new Prefixes(__DIR__.'/nstst/prefixes.txt');
        $this->assertSame('через', $prefixes->translate('trans'));
        $this->assertSame('сквозь', $prefixes->translate('tra'));
        $this->assertNull($prefixes->translate('qwerty'));
    }
}
