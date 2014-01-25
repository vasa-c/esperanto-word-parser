<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Phonetics
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Phonetics
{
    /**
     * Constructor
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $s2 = [];
        $r2 = [];
        $s1 = [];
        $r1 = [];
        foreach (FileLoader::load($filename) as $k => $v) {
            if (\strlen($k) > 1) {
                $s2[] = $k;
                $r2[] = $v;
            } else {
                $s1[] = $k;
                $r1[] = $v;
            }
        }
        $this->replS = \array_merge($s2, $s1);
        $this->replR = \array_merge($r2, $r1);
    }

    /**
     * @param string $content
     * @return string
     */
    public function __invoke($content)
    {
        $content = Diacritic::diacritic2latin($content);
        return \str_replace($this->replS, $this->replR, $content);
    }

    /**
     * @var array
     */
    private $replS;

    /**
     * @var array
     */
    private $replR;
}
