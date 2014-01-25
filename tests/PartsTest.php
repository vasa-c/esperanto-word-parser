<?php
/**
 * @package go\ewp
 */

namespace go\ewp\tests;

use go\ewp\Parts;

/**
 * @coversDefaultClass go\ewp\Parts
 */
class PartsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers ::define
     * @dataProvider providerDefineNoAp
     * @param string $word
     * @param array $expected
     */
    public function testDefineNoAp($word, $expected)
    {
        $this->assertEquals($expected, (array)Parts::define($word, false));
    }

    /**
     * @return array
     */
    public function providerDefineNoAp()
    {
        return [
            [
                'foto',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                ],
            ],
            [
                'fota',
                [
                    'remain' => 'fot',
                    'part' => 'a',
                ],
            ],
            [
                'fote',
                [
                    'remain' => 'fot',
                    'part' => 'e',
                ],
            ],
            [
                'foti',
                [
                    'remain' => 'fot',
                    'part' => 'i',
                ],
            ],
            [
                'fotis',
                [
                    'remain' => 'fot',
                    'part' => 'is',
                ],
            ],
            [
                'fotas',
                [
                    'remain' => 'fot',
                    'part' => 'as',
                ],
            ],
            [
                'fotus',
                [
                    'remain' => 'fot',
                    'part' => 'us',
                ],
            ],
            [
                'fotu',
                [
                    'remain' => 'fot',
                    'part' => 'u',
                ],
            ],
            [
                'fotinta',
                [
                    'remain' => 'fotint',
                    'part' => 'a',
                ],
            ],
            [
                'ankoraux',
                [
                    'remain' => 'ankoraux',
                    'part' => null,
                ],
            ],
            [
                'is',
                [
                    'remain' => 'is',
                    'part' => null,
                ],
            ],
        ];
    }

    /**
     * @covers ::define
     * @dataProvider providerDefineAp
     * @param string $word
     * @param array $expected
     */
    public function testDefineAp($word, $expected)
    {
        $this->assertEquals($expected, (array)Parts::define($word, true));
    }

    /**
     * @return array
     */
    public function providerDefineAp()
    {
        return [
            [
                'foto',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                    'accus' => false,
                    'plural' => false,
                ],
            ],
            [
                'foton',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                    'accus' => true,
                    'plural' => false,
                ],
            ],
            [
                'fotoj',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                    'accus' => false,
                    'plural' => true,
                ],
            ],
            [
                'fotojn',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                    'accus' => true,
                    'plural' => true,
                ],
            ],
            [
                'fotonj',
                [
                    'remain' => 'fot',
                    'part' => 'o',
                    'accus' => true,
                    'plural' => true,
                ],
            ],
            [
                'fotonn',
                [
                    'remain' => 'fotonn',
                    'part' => null,
                    'accus' => false,
                    'plural' => false,
                ],
            ],
            [
                'onj',
                [
                    'remain' => 'onj',
                    'part' => null,
                    'accus' => false,
                    'plural' => false,
                ],
            ],
        ];
    }
}
