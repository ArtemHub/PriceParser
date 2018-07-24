<?php

namespace PriceParser;

use PriceParser\Row\CategoryRow;
use PriceParser\Row\RecordRow;
use PriceParser\Row\SubcategoryRow;

use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;
use PhpOffice\PhpSpreadsheet\Worksheet\Row as Row;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator as RowCellIterator;

class RowFactory
{

    private function __construct() {}

    /**
     * @param Row $row
     * @return null|CategoryRow|RecordRow|SubcategoryRow
     */
    public static function getRow($row) {
        $cellIterator = $row->getCellIterator();
        try {
            $cellIterator->setIterateOnlyExistingCells(FALSE);
        } catch (PhpSpreadsheetException $ex) {
            die($ex->getTraceAsString());
        }

        $result = null;
        switch (self::getType($cellIterator)) {
            case RowType::CATEGORY()->getKey():
                $result = new CategoryRow($row);
                break;
            case RowType::SUBCATEGORY()->getKey():
                $result = new SubcategoryRow($row);
                break;
            case RowType::RECORD()->getKey():
                $result = new RecordRow($row);
                break;
        }

        return $result;
    }

    /**
     * @param RowCellIterator $cellIterator
     * @return string
     */
    private static function getType($cellIterator)
    {
        $cell = $cellIterator->current();
        $color = $cell->getStyle()->getFill()->getEndColor()->getRGB();

        if($color == RowType::CATEGORY()) {
            return RowType::CATEGORY()->getKey();
        }

        if($color == RowType::SUBCATEGORY()) {
            return RowType::SUBCATEGORY()->getKey();
        }

        if($color == RowType::RECORD()) {
            return RowType::RECORD()->getKey();
        }
    }
}