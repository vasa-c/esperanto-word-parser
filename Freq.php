<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * Frequency dictionary compilation
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Freq
{
    /**
     * Appends a content for parsing
     *
     * @param string $content
     */
    public function appendContent($content)
    {
        $content = Diacritic::diacritic2latin($content);
        if (!\preg_match_all('/[a-z]+/', $content, $matches)) {
            return;
        }
        foreach ($matches[0] as $word) {
            if (isset($this->words[$word])) {
                $this->words[$word]++;
            } else {
                $this->words[$word] = 1;
            }
        }
        $this->count += \count($matches[0]);
    }

    /**
     * Appends a file for parsing of its content
     *
     * @param string $filename
     */
    public function appendFile($filename)
    {
        $this->appendContent(\file_get_contents($filename));
    }

    /**
     * Get the list of words (sorted by frequency)
     *
     * @return array
     *         word => count
     */
    public function getWords()
    {
        return $this->words;
    }

    /**
     * Get the plain list of words
     *
     * @return array
     */
    public function getPlainWordsList()
    {
        return \array_keys($this->words);
    }

    /**
     * Get the count of all words
     *
     * @return array
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @var array
     */
    private $words = [];

    /**
     * @var int
     */
    private $count = 0;
}
