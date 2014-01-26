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
     * @covers ::parse
     * @dataProvider providerParse
     * @param string $word
     * @param mixed $expected
     */
    public function testParse($word, $expected)
    {
        $parser = \go\ewp\Locale::getSysLocale('ru')->getParser();
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
            [
                'la',
                'la',
            ],
        ];
    }
}
