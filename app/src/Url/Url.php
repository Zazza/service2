<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 14:58
 */
namespace App\Url;

use App\Exception\UrlErrorException;

class Url
{
    /** @var string */
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return bool
     * @throws UrlErrorException
     */
    public function validate()
    {
        $pattern = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]-*)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$_iuS';
        if (!preg_match($pattern, $this->url)) {
            throw new UrlErrorException();
        }

        return true;
    }

    /**
     * @param int $strength
     * @return string
     */
    public function generate($strength = 5)
    {
        $Model = true;
        while ($Model !== false) {
            $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $inputLength = strlen($input);
            $randomString = '';
            for ($i = 0; $i < $strength; $i++) {
                $randomCharacter = $input[mt_rand(0, $inputLength - 1)];
                $randomString .= $randomCharacter;
            }

            /** @var \Models\Url $Model */
            $Model = \Models\Url::findFirst([
                'assign = :assign:',
                'bind' => ['assign' => $randomString]
            ]);
        }

        return $randomString;
    }
}
