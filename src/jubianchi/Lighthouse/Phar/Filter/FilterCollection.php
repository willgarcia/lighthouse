<?php
/**
 * This file is part of lighthouse.
 *
 * (c) Julien Bianchi <contact@jubianchi.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace jubianchi\Lighthouse\Phar\Filter;

use jubianchi\Lighthouse\Phar;

class FilterCollection implements \Iterator, \ArrayAccess, Phar\Filter
{
    protected $filters = array();

    public function add(Phar\Filter $filter, $offset = null)
    {
        if (false === in_array($filter, $this->filters, true)) {
            $offset = $offset ?: count($this->filters);

            $this->filters[$offset] = $filter;
        }

        return $this;
    }

    public function current()
    {
        return current($this->filters);
    }

    public function next()
    {
        next($this->filters);
    }

    public function key()
    {
        return key($this->filters);
    }

    public function valid()
    {
        return $this->key() !== null;
    }

    public function rewind()
    {
        reset($this->filters);
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->filters);
    }

    public function offsetGet($offset)
    {
        return $this->filters[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->add($value, $offset);
    }

    public function offsetUnset($offset)
    {
        unset($this->filters[$offset]);
    }
    
    public function __invoke($contents, array $tokens)
    {
        foreach ($this->filters as $filter) {
            $contents = call_user_func_array($filter, array($contents, $tokens));
        }

        return $contents;
    }
}
