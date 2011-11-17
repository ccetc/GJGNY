<?php

namespace GJGNY\DataToolBundle\Resources\classes;

class Strings {
  /**
   * Takes $timestamp and makes the date look nice
   * 
   * example:
   *  March 12, 2011
   * 
   * @param string $timestamp the date to display
   * @return string the formatted date from $timestamp
   */
  static function formatDateString($timestamp)
  {
    $timestamp = strtotime($timestamp);
    return date("F j, Y", $timestamp);
  }
  
  static function formatDateTime($dateTime) {
    return $dateTime->format("F j, Y");
  }
}

