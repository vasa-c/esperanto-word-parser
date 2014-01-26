<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * @coversDefaultClass go\ewp\Parser
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \go\ewp\Parser
     */
    private function getParser()
    {
        static $parser;
        if (!$parser) {
            $parser = \go\ewp\Locale::getSysLocale('ru')->getParser();
        }
        return $parser;
    }

    /**
     * @covers ::parse
     * @dataProvider providerParse
     * @param string $word
     * @param mixed $expected
     */
    public function testParse($word, $expected)
    {
        $parser = $this->getParser();
        $result = $parser->parse($word);
        if ($expected === null) {
            $this->assertNull($result);
        } else {
            $this->assertInstanceOf('go\ewp\Result', $result);
            $this->assertSame($expected, (string)$result);
        }
    }

    /**
     * @return array
     */
    public function providerParse()
    {
        return [
            ['', null],
            ['d', null],
            ['la', 'la'],
            ['li', 'li'],
            ['lin', 'li(n)'],
            ['kaj', 'kaj'],
            ['esti', 'est[i]'],
            ['estis', 'est[is]'],
            ['estas', 'est[as]'],
            ['estos', 'est[os]'],
            ['oni', 'oni'],
            ['pri', 'pri'],
            ['tamen', 'tamen'],
            ['kuriero', 'kuri<er>[o]'],
            ['malantaux', '(mal)antaux'],
            ['ekmalfermigxis', '(ek)(mal)ferm<igx>[is]'],
            ['dismetitaj', 'dismet<it>[a](j)'],
            ['malrapide', '(mal)rapid[e]'],
            ['denove', 'denov[e]'],
            ['demonte', '(de)mont[e]'],
        ];
    }
}
