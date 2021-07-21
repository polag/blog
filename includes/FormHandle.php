<?php
namespace DataHandle;

use \DataHandle\Utils\InputSanitize;

abstract class FormHandle
{
    //use \DataHandle\Utils\InputSanitize;
    abstract public static function insertBook($form_data);
    abstract public static function selectBook($id = null, $userId = null);
    abstract public static function deleteBook($id);
    abstract public static function updateBook($form_data, $id);
  
}