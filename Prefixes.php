<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Word prefixes
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Prefixes
{
    /**
     * Constructor
     *
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->prefixes = FileLoader::load($filename);
        $this->lens = [];
        foreach ($this->prefixes as $k => $v) {
            $this->lens[$k] = \strlen($k);
        }
    }

    /**
     * Find a prefix for a word
     *
     * @param string $word
     * @return array
     *         (prefix, word) or NULL
     */
    public function find($word)
    {
        foreach ($this->lens as $prefix => $len) {
            if (\strpos($word, $prefix) === 0) {
                $w = \substr($word, $len);
                if ($w) {
                    return [$prefix, $w];
                }
            }
        }
        return null;
    }

    /**
     * Translate a prefix
     *
     * @param string $prefix
     * @return string
     */
    public function translate($prefix)
    {
        return isset($this->prefixes[$prefix]) ? $this->prefixes[$prefix] : null;
    }

    /**
     * @var array
     */
    private $prefixes;

    /**
     * @var array
     */
    private $lens;
}
