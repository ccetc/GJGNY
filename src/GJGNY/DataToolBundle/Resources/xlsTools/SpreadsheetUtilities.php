<?php

namespace GJGNY\DataToolBundle\Resources\xlsTools;

class SpreadsheetUtilities
{

  private $spreadsheet;
  public $insertions = array();
  public $deletions = array();
  public $updates = array();

  public function __construct($filename)
  {
    $this->spreadsheet = \PHPExcel_IOFactory::load($filename);
  }

  public function getVal($cell)
  {
      if(trim($this->spreadsheet->getActiveSheet()->getCell($cell)->getValue()) == "")
      {
          return null;
      }
      else
      {
        return trim($this->spreadsheet->getActiveSheet()->getCell($cell)->getValue());      
      }
  }

  protected function getBoolVal($cell)
  {
    if($this->isYes($this->getVal($cell)))
    {
      return 'yes';
    }
    else if($this->isNo($this->getVal($cell)))
    {
      return 'no';
    }
    else
      return false;
  }

  protected function getDateVal($cell)
  {
    if(trim($this->getVal($cell)) != "" && trim($this->getVal($cell)) != "N/A" && trim($this->getVal($cell)) != "n/a")
    {
      $val = trim($this->getVal($cell));
      return \PHPExcel_Style_NumberFormat::toFormattedString($val, "M/D/YYYY");
    }
    else
      return false;
  }

   protected function getTimeVal($cell)
  {
    if(trim($this->getVal($cell)) != "" && trim($this->getVal($cell)) != "N/A" && trim($this->getVal($cell)) != "n/a")
    {
      $val = trim($this->getVal($cell));
      return \PHPExcel_Style_NumberFormat::toFormattedString($val, "H:i:s");
    }
    else
      return false;
  }

  
  protected function getDateTimeVal($cell)
  {
    if(trim($this->getVal($cell)) != "" && trim($this->getVal($cell)) != "N/A" && trim($this->getVal($cell)) != "n/a")
    {
      $val = trim($this->getVal($cell));
      return \PHPExcel_Style_NumberFormat::toFormattedString($val, "M/D/YYYY H:i:s");
    }
    else
      return false;
  }  
  
  protected function getTextVal($cell)
  {
    if(trim($this->getVal($cell)) != "" && trim($this->getVal($cell)) != "N/A" && trim($this->getVal($cell)) != "n/a")
    {
      return trim($this->getVal($cell));
    }
    else
      return false;
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
    return in_array($value, array('NO', 'n', '0'));
  }

  protected function makeStringBool($string)
  {
    if($string == 'yes')
      return true;
    else
      return false;
  }

}