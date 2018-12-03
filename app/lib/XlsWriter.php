<?php

namespace app\lib;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class XlsWriter
{
    public $title;
    public $spreadsheet;
    public $sheet;

    public function __construct($title = 'page') {
        $this->spreadsheet = new Spreadsheet();
        $this->sheet = $this->spreadsheet->getActiveSheet();
        $this->sheet->setTitle($title);
    }

    public function writeTitles($array, $i, $j){
        for($k = 0, $size = count($array); $k < $size; $k++, $i++){
            $this->sheet->setCellValue($i.$j, $array[$k]);
            $this->sheet->getStyle($i.$j)->getFont()->setBold(true);
        }
    }

    public function writeArrVal($array, $i = 2, $j = 2){
        $temp = $i;
        foreach ($array as $row) {
            $i = $temp;
            foreach($row as $col){
                $this->sheet->setCellValue($i.$j, $col);
                $i++;
            }
            $j++;
        }
    }

    public function save($title = 'doc'){
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($title.'.xlsx');
    }
}