<?php

namespace PriceParser\Row;

class RecordRow extends Row
{
    private $name;
    private $price;

    function initData()
    {
        $this->name = parent::getCells()[1];
        $this->price = parent::getCells()[2];
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}