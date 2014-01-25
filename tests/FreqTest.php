<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Freq;

/**
 * @coversDefaultClass go\ewp\Freq
 */
class FreqTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::appendContent
     * @covers ::appendFile
     * @covers ::getWords
     * @covers ::getPlainWordsList
     * @covers ::getCount
     */
    public function testFreq()
    {
        $f = new Freq();
        $f->appendFile(__DIR__.'/nstst/freq1.txt');
        $words = [
            'unu' => 3,
            'tri' => 3,
            'kvar' => 3,
            'nul' => 2,
            'du' => 2,
            'kvin' => 2,
            'ses' => 2,
            'ok' => 2,
            'naux' => 2,
        ];
        $this->assertEquals($words, $f->getWords());
        $this->assertCount(9, $f->getPlainWordsList());
        $this->assertSame(21, $f->getCount());
        $f->appendFile(__DIR__.'/nstst/freq2.txt');
        $words = [
            'tri' => 7,
            'kvar' => 5,
            'unu' => 4,
            'du' => 4,
            'ok' => 4,
            'naux' => 4,
            'kvin' => 3,
            'nul' => 2,
            'ses' => 2,
            'sep' => 1,
        ];
        $this->assertEquals($words, $f->getWords());
        $this->assertCount(10, $f->getPlainWordsList());
        $this->assertSame(36, $f->getCount());
    }
}
