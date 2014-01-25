<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Phonetics;

/**
 * @coversDefaultClass go\ewp\Phonetics
 */
class PhoneticsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__invoke
     */
    public function testPhonetics()
    {
        $phonetics = new Phonetics(__DIR__.'/nstst/phonetics.txt');
        $content = 'Detruado de banka posedaĵo estas krimo. Vi estas arestita.';
        $expected = 'дэтруадо дэ банка посэдажо эстас кримо. ви эстас арэстита.';
        $this->assertSame($expected, $phonetics($content));
    }
}
