<?php

require dirname(__FILE__) . '/vendor/autoload.php';

$inputFileName = dirname(__FILE__) . '/price.xls';

$worksheet = PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName)->getActiveSheet();
$rows = [];
foreach ($worksheet->getRowIterator() AS $row) {
    $row = PriceParser\RowFactory::getRow($row);
    if($row->getName() != "Назва послуги") {
        $rows[] = $row;
    }
}

$tmp_category = '<div class="price"><h4>{NAME}</h4>{CONTAINER}</div>';
$tmp_subcategory = '<div class="button">{NAME}</div><div class="table"><table border="0" cellspacing="0"><tbody>{TABLE}</tbody></table></div>';

$result = '';
$category = '';
$container = '';
$subcategory = '';
$table = '';
foreach ($rows as $key => $row) {
    if(get_class($row) == 'PriceParser\Row\CategoryRow') {
        $category = $row->getName();
    }
    else if(get_class($row) == 'PriceParser\Row\SubcategoryRow') {
        $subcategory = $row->getName();
    }
    else if(get_class($row) == 'PriceParser\Row\RecordRow') {
        $table.= '<tr><td>' . $row->getName() . '</td><td>' . $row->getPrice() . ' <span>грн</span></td></tr>';

        $next = $rows[$key+1];
        if($next && get_class($next) == 'PriceParser\Row\SubcategoryRow') {
            $container.= str_replace(['{NAME}', '{TABLE}'], [$subcategory, $table], $tmp_subcategory);
            $table = '';
            $subcategory = '';
        }
        else if($next && get_class($next) == 'PriceParser\Row\CategoryRow') {
            $container.= str_replace(['{NAME}', '{TABLE}'], [$subcategory, $table], $tmp_subcategory);
            $table = '';
            $subcategory = '';

            $result.= str_replace(['{NAME}', '{CONTAINER}'], [$category, $container], $tmp_category);
            $container = '';
            $category = '';
        }
        else if(!isset($next)) {
            $container.= str_replace(['{NAME}', '{TABLE}'], [$subcategory, $table], $tmp_subcategory);
            $table = '';
            $subcategory = '';

            $result.= str_replace(['{NAME}', '{CONTAINER}'], [$category, $container], $tmp_category);
            $container = '';
            $category = '';
        }
    }
}

print_r($result);
die();