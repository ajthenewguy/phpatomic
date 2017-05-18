<?php

namespace Phpatomic;

use Phpatomic\Exceptions\StackOverflowException;
use Phpatomic\Exceptions\StackUnderflowException;

/**
 * Created by PhpStorm.
 * User: allenmccabe
 * Date: 5/18/17
 */

class Stack
{
    private $maxsize;

    private $top;

    private $items;

    private static $type;


    public function __construct($items = [], $maxsize = 0)
    {
        $this->setItems($items);
        $this->setMaxsize($maxsize);
        $this->top = 0;
    }

    public static function type($type = null)
    {
        if (! isset(static::$type) || is_null(static::$type)) {
            static::$type = $type;
        }

        return static::$type;
    }

    public function duplicate()
    {
        $item = $this->pop();
        $this->push($item);
        if (is_object($item)) {
            $newitem = clone $item;
        } else {
            $newitem = $item;
        }
        $this->push($newitem);
    }

    public function isEmpty()
    {
        return $this->top < 1;
    }

    public function maxsize()
    {
        return $this->maxsize;
    }

    public function peek()
    {
        if (! $this->isEmpty()) {
            return $this->items[$this->top];
        }
    }

    public function pop()
    {
        if ($this->top > 0) {
            $this->top--;
            return array_pop($this->items);
        } else {
            throw new StackUnderflowException();
        }
    }

    public function push($item)
    {
        if ($this->maxsize < 1 || $this->top < $this->maxsize) {
            if (static::validateType($item)) {
                $this->items[$this->top] = $item;
                $this->top++;
            } else {
                throw new \InvalidArgumentException(sprintf('Members must be of type %s', static::type()));
            }

        } else {
            throw new StackOverflowException();
        }

        return $this;
    }

    public function swap()
    {
        if (count($this->items) > 1) {
            $temp_first = $this->pop();
            $temp_next = $this->pop();
            $this->push($temp_first);
            $this->push($temp_next);
        } else {
            throw new StackUnderflowException();
        }
    }

    public function toArray()
    {
        return $this->items;
    }

    public function top()
    {
        return $this->top;
    }

    protected static function getType($item)
    {
        $type = gettype($item);
        if ($type == 'object') {
            $type = get_class($item);
        }

        return $type;
    }

    protected static function validateType($item)
    {
        $type = static::type();
        $item_type = static::getType($item);

        if (is_null($type)) {
            static::type($type = $item_type);
        }

        return $type === $item_type;
    }

    protected function setMaxsize($maxsize = 0)
    {
        $this->maxsize = (int) $maxsize;
        return $this;
    }

    protected function setItems($items = [])
    {
        foreach ((array) $items as $item) {
            $this->push($item);
        }

        return $this;
    }
}
