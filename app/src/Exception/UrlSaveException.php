<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 15:25
 */
namespace App\Exception;

class UrlSaveException extends \Exception
{
    protected $message = 'Save error';
    protected $code = 4;
}
