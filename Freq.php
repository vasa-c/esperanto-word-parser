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
     * Constructor
     *
     * @param string $filename [optional]
     */
    public function __construct($filename = null)
    {
        if ($filename !== null) {
            $this->appendFile($filename);
        }
    }

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
        \arsort($this->words);
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
     * @param \go\ewp\Parser $parser
     * @reutrn array
     *         (success, fail, uniq, words, puniq, pwords, perunit, perwords)
     */
    public function passParser(Parser $parser)
    {
        $result = (object)[
            'success' => [],
            'fail' => [],
            'uniq' => \count($this->words),
            'words' => $this->count,
            'pwords' => 0,
            'puniq' => 0,
            'peruniq' => 0,
            'perwords' => 0,
        ];
        if (empty($this->words)) {
            return $result;
        }
        foreach ($this->words as $word => $count) {
            $r = $parser->parse($word);
            if ($r !== null) {
                $result->success[$word] = (string)$r;
                $result->puniq++;
                $result->pwords += $count;
            } else {
                $result->fail[] = $word;
            }
        }
        $result->peruniq = (int)($result->puniq * 100 / $result->uniq);
        $result->perwords = (int)($result->pwords * 100 / $result->words);
        return $result;
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
