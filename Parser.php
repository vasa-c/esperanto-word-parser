<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * The parser of words
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Parser
{
    /**
     * Constructor
     *
     * @param \go\ewp\Locale $locale
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
    }

    /**
     * Parses a word
     *
     * @param string $word
     * @return \go\ewp\Result
     *         an instance of result or NULL
     */
    public function parse($word)
    {
        $dict = $this->locale->getDict();
        $r = $dict->getRoot($word);
        if ($r !== null) {
            $result = new Result;
            $result->root = $word;
            return $result;
        }
        return null;
    }

    /**
     * @var \go\ewp\Locale
     */
    private $locale;
}
