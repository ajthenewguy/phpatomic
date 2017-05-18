<?php

namespace Phpatomic;

/**
 * Created by PhpStorm.
 * User: allenmccabe
 * Date: 5/18/17
 * Time: 4:36 PM
 */

trait Hierarchy
{
    private $parent;

    private $children;


    public function spawn($child)
    {
        if (! isset($this->children)) {
            $this->children = [];
        }

        $this->children[] = $child;
    }

    public function parent()
    {
        return $this->parent;
    }

    public function children()
    {
        return $this->children;
    }

    public function setParent($parent)
    {
        if (! isset($this->parent)) {
            $this->parent = $parent;
        } else {
            throw new \Exception('This instance already has a parent');
        }

        return $this;
    }
}