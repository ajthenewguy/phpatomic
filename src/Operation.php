<?php

namespace Phpatomic;

/**
 * Created by PhpStorm.
 * User: allenmccabe
 * Date: 5/18/17
 * Time: 4:13 PM
 */

class Operation
{
    use Hierarchy;


    private $serial;

    const HEAD = 0;


    public function __construct($parent = null)
    {
        $this->init($parent);
    }

    public function init($parent = null)
    {
        if (is_null($parent)) {
            $this->serial = self::HEAD;
        } else {
            $this->setParent($parent);
        }
    }
}