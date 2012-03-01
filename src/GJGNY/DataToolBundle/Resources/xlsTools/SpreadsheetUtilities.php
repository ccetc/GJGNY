<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

class SpreadsheetUtilities
{

    private $spreadsheet;
    public $entityManager;
    public $insertions;
    public $updates;
    public $deletions;
    public $duplicates;

    public function __construct($filename, $entityManager)
    {
        $this->spreadsheet = \PHPExcel_IOFactory::load($filename);
        $this->entityManager = $entityManager;
        $this->insertions = array();
        $this->updates = array();
        $this->deletions = array();
        $this->duplicates = array();
    }

    public function processRows()
    {
        $row = 2;
        $atAnEmptyRow = false;
        while(!$atAnEmptyRow) {
            if($this->rowIsEmpty($row)) {
                $atAnEmptyRow = true;
            } else {
                $this->processRow($row);
            }

            $row++;
        }
    }
    
    public function processRow($row) {

    }

    public function rowIsEmpty($row)
    {
        return trim($this->getVal('A' . $row)) == ''
                && trim($this->getVal('B' . $row)) == ''
                && trim($this->getVal('C' . $row)) == ''
                && trim($this->getVal('D' . $row)) == ''
                && trim($this->getVal('E' . $row)) == ''
                && trim($this->getVal('F' . $row)) == '';
    }

    public function persistObject($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    public function getVal($cell)
    {
        if(trim($this->spreadsheet->getActiveSheet()->getCell($cell)->getValue()) == "") {
            return null;
        } else {
            return trim($this->spreadsheet->getActiveSheet()->getCell($cell)->getValue());
        }
    }

    protected function getBoolVal($cell)
    {
        if($this->isYes($this->getVal($cell))) {
            return true;
        } else if($this->isNo($this->getVal($cell))) {
            return false;
        } else {
            return null;
        }
    }

    protected function isYes($value)
    {
        $value = (string) $value;
        $value = trim(strtoupper($value));
        return in_array($value, array('YES', 'Y', '1'));
    }

    protected function isNo($value)
    {
        $value = (string) $value;
        $value = trim(strtoupper($value));
        return in_array($value, array('NO', 'N', '0'));
    }

    protected function getDateVal($cell)
    {
        return $this->getAbstractDateTimeVal($cell, "M/D/YYYY");
    }

    protected function getTimeVal($cell)
    {
        return $this->getAbstractDateTimeVal($cell, "H:i:s");
    }

    protected function getDateTimeVal($cell)
    {
        return $this->getAbstractDateTimeVal($cell, "M/D/YYYY H:i:s");
    }

    protected function getAbstractDateTimeVal($cell, $pattern)
    {
        $val = $this->getVal($cell);

        if(isset($val)) {
            return \PHPExcel_Style_NumberFormat::toFormattedString($val, $pattern);
        } else {
            return null;
        }
    }

}