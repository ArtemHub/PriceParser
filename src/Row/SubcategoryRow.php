<?php

namespace PriceParser\Row;

class SubcategoryRow extends Row
{
    private $name;

    function initData()
    {
        $this->name = parent::getCells()[0];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}