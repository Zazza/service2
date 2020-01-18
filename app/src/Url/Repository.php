<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.01.20
 * Time: 13:02
 */
namespace App\Url;

use App\Exception\UrlNotFoundException;
use App\Exception\UrlSaveException;

class Repository
{
    /** @var string */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @param $randomString
     * @return bool
     * @throws UrlSaveException
     */
    public function save($randomString)
    {
        $Model = new \Models\Url();
        $Model->url = $this->url;
        $Model->assign = $randomString;
        if (!$Model->save()) {
            throw new UrlSaveException(implode(', ', $Model->getMessages()));
        }

        return true;
    }

    /**
     * @param $assign
     * @return string
     * @throws UrlNotFoundException
     */
    public static function getFromShort($assign)
    {
        /** @var \Models\Url $Url */
        $Url = \Models\Url::findFirst([
            'assign = :assign:',
            'bind' => ['assign' => $assign]
        ]);
        if (!$Url) {
            throw new UrlNotFoundException();
        }

        return $Url->url;
    }
}
