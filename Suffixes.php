<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Word suffixes
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Suffixes
{
    /**
     * Constructor
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->suffixes = FileLoader::load($filename);
        $this->lens = [];
        foreach ($this->suffixes as $k => $v) {
            $this->lens[$k] = \strlen($k);
        }
    }

    /**
     * Find a suffix for a word
     *
     * @param string $word
     * @return array
     *         (prefix, word) or NULL
     */
    public function find($word)
    {
        foreach ($this->lens as $suffix => $len) {
            if (\substr($word, -$len) === $suffix) {
                $w = \substr($word, 0, -$len);
                if (\strlen($w) > 1) {
                    return [$w, $suffix];
                }
            }
        }
        return null;
    }

    /**
     * Translate a suffix
     *
     * @param string $suffix
     * @return string
     */
    public function translate($suffix)
    {
        return isset($this->suffixes[$suffix]) ? $this->suffixes[$suffix] : null;
    }

    /**
     * @var array
     */
    private $suffixes;

    /**
     * @var array
     */
    private $lens;
}
