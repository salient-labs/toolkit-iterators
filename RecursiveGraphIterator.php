<?php declare(strict_types=1);

namespace Salient\Iterator;

use Salient\Iterator\Concern\RecursiveGraphIteratorTrait;
use RecursiveIterator;

/**
 * Iterates over the properties and elements of objects and arrays, descending
 * into them recursively
 *
 * @implements RecursiveIterator<array-key,mixed>
 */
class RecursiveGraphIterator extends GraphIterator implements RecursiveIterator
{
    use RecursiveGraphIteratorTrait;
}
