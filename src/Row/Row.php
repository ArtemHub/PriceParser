<?php

namespace PriceParser\Row;

use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
use PhpOffice\PhpSpreadsheet\Worksheet\Row as PhpOfficeRow;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator as RowCellIterator;
use PhpOffice\PhpSpreadsheet\Cell\Cell as Cell;

abstract class Row {

    private $cells = array();
    private $size;

    abstract function initData();

    /**
     * Row constructor.
     * @param PhpOfficeRow $row
     */
    public function __construct($row)
    {
        $cellIterator = $row->getCellIterator();
        try {
            $cellIterator->setIterateOnlyExistingCells(FALSE);
        } catch (PhpSpreadsheetException $ex) {
            die($ex->getTraceAsString());
        }

        $this->parse($cellIterator);
    }

    /**
     * Row parse row data.
     * @param RowCellIterator $cellIterator
     */
    private function parse($cellIterator) {
        foreach ($cellIterator as $cell) {
            $this->setCells($cell);
        }
        $this->size = sizeof($this->cells);

        $this->initData();
    }

    /**
     * @param Cell $cell
     */
    private function setCells($cell) {
        $this->cells[] = $cell->getValue();
    }

    /**
     * @return array
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }
}