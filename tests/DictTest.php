<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Dict;

/**
 * @coversDefaultClass go\ewp\Dict
 */
class DictTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::loadFromFile
     * @covers ::getRoot
     */
    public function testGetRoot()
    {
        $filename = __DIR__.'/nstst/dictroot.txt';
        $dict = Dict::loadFromFile($filename);
        $this->assertInstanceOf('go\ewp\Dict', $dict);
        $this->assertSame('abelo', $dict->getRoot('abelo'));
        $this->assertSame('aludi', $dict->getRoot('aludi'));
        $this->assertSame('ambaux', $dict->getRoot('ambaux'));
        $this->assertSame('abelo', $dict->getRoot('abel'));
        $this->assertSame('aludi', $dict->getRoot('alud'));
        $this->assertSame(null, $dict->getRoot('ama'));
    }

    /**
     * @covers ::translate
     */
    public function testTranslate()
    {
        $filename = __DIR__.'/nstst/dictroot.txt';
        $dict = Dict::loadFromFile($filename);
        $this->assertSame('bee', $dict->translate('abelo'));
        $this->assertSame(null, $dict->translate('abel'));
        $this->assertSame(null, $dict->translate('qwerty'));
    }
}
