<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Locale;

/**
 * @coversDefaultClass go\ewp\Locale
 */
class LocaleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::getDict
     * @covers ::getPhonetics
     */
    public function testLocale()
    {
        $locale = Locale::getSysLocale('ru');
        $dict = $locale->getDict();
        $this->assertInstanceOf('go\ewp\Dict', $dict);
        $this->assertSame('abelo', $dict->getRoot('abel'));
        $phonetics = $locale->getPhonetics();
        $this->assertInstanceOf('go\ewp\Phonetics', $phonetics);
        $this->assertSame('абэло', $phonetics('abelo'));
        $prefixes = $locale->getPrefixes();
        $this->assertInstanceOf('go\ewp\Prefixes', $prefixes);
        $this->assertEquals(['mal', 'ware'], $prefixes->find('malware'));
        $suffixes = $locale->getSuffixes();
        $this->assertInstanceOf('go\ewp\Suffixes', $suffixes);
        $this->assertEquals(['fot', 'int'], $suffixes->find('fotint'));
    }
}
