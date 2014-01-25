<?php
/**
 * @package go\ewp
 */

namespace go\ewp;

/**
 * The dictionary of word roots
 *
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */
class Dict
{
    /**
     * Constructor
     *
     * @param array $roots
     */
    public function __construct($roots)
    {
        $this->roots = $roots;
    }

    /**
     * Load the dictionary from a file
     *
     * @param string $filename
     * @return \go\ewp\Dict
     */
    public static function loadFromFile($filename)
    {
        return new self(FileLoader::load($filename));
    }

    /**
     * Returns common form of a root
     *
     * @param string $root
     * @return string|null
     */
    public function getRoot($root)
    {
        if (isset($this->roots[$root])) {
            return $root;
        }
        if ($this->sroots === null) {
            $this->createSRoots();
        }
        if (isset($this->sroots[$root])) {
            return $this->sroots[$root];
        }
    }

    /**
     * Returns the translation of the root
     *
     * @param string $root
     * @return string|null
     */
    public function translate($root)
    {
        return isset($this->roots[$root]) ? $this->roots[$root] : null;
    }

    /**
     * Returns the list of roots
     *
     * @return array
     */
    public function listRoots()
    {
        return $this->roots;
    }

    /**
     * Create the list of short roots
     */
    private function createSRoots()
    {
        $this->sroots = [];
        foreach ($this->roots as $k => $v) {
            $p = Parts::define($k, false);
            if ($p->part !== null) {
                $this->sroots[$p->remain] = $k;
            }
        }
    }

    /**
     * @var array
     */
    private $roots;

    /**
     * @var array
     */
    private $sroots;
}
