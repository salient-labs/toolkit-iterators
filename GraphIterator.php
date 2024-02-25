<?php declare(strict_types=1);

namespace Lkrms\Iterator;

use Iterator;
use LogicException;
use ReturnTypeWillChange;
use Traversable;

/**
 * Iterates over the properties or elements of an object or array
 *
 * @implements Iterator<array-key,mixed>
 */
class GraphIterator implements Iterator
{
    /**
     * @var object|mixed[]
     */
    protected $Graph;

    /**
     * @var array<array-key>
     */
    protected array $Keys = [];

    protected bool $IsObject = true;

    /**
     * @param object|mixed[] $graph
     */
    public function __construct($graph)
    {
        $this->doConstruct($graph);
    }

    /**
     * @param object|mixed[] $graph
     */
    protected function doConstruct(&$graph): void
    {
        if (is_array($graph)) {
            $this->Graph = &$graph;
            $this->Keys = array_keys($graph);
            $this->IsObject = false;
            return;
        }

        if ($graph instanceof Traversable) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Traversable objects are not supported');
            // @codeCoverageIgnoreEnd
        }

        $this->Graph = $graph;
        foreach ($graph as $key => $value) {
            $this->Keys[] = $key;
        }
    }

    /**
     * @return mixed|false
     */
    #[ReturnTypeWillChange]
    public function current()
    {
        $key = current($this->Keys);
        if ($key === false) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }

        return
            $this->IsObject
                ? $this->Graph->{$key}
                : $this->Graph[$key];
    }

    /**
     * @return array-key|null
     */
    #[ReturnTypeWillChange]
    public function key()
    {
        $key = current($this->Keys);
        if ($key === false) {
            // @codeCoverageIgnoreStart
            return null;
            // @codeCoverageIgnoreEnd
        }
        return $key;
    }

    public function next(): void
    {
        next($this->Keys);
    }

    public function rewind(): void
    {
        reset($this->Keys);
    }

    public function valid(): bool
    {
        return current($this->Keys) !== false;
    }
}
