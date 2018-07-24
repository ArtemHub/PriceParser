<?php

namespace PriceParser;

use MyCLabs\Enum\Enum;

/**
 * @method static RowType CATEGORY()
 * @method static RowType SUBCATEGORY()
 * @method static RowType RECORD()
 */
class RowType extends Enum
{
    private const CATEGORY = 'CCFFFF';
    private const SUBCATEGORY = 'FFFFCC';
    private const RECORD = 'FFFFFF';
}