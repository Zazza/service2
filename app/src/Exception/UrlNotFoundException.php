<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 15:25
 */
namespace App\Exception;

class UrlNotFoundException extends \Exception
{
    protected $message = 'URL not found';
    protected $code = 3;
}
