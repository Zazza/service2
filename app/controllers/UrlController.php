<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 17.01.20
 * Time: 14:46
 */
namespace Controllers;

use Datto\JsonRpc\Exceptions\ApplicationException;
use Phalcon\Mvc\Controller;
use App\Url;

class UrlController extends Controller
{
    /**
     * @param $url
     * @return array
     * @throws ApplicationException
     */
    public function generateAction($url)
    {
        try {
            $Url = new Url\Url($url);
            $Url->validate();
            $randomString = $Url->generate();

            $Repository = new Url\Repository($url);
            $Repository->save($randomString);
        } catch (\Exception $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }

        return ['message' => $randomString];
    }

    /**
     * @param $assign
     * @return array
     * @throws ApplicationException
     */
    public function getFromAssignAction($assign)
    {
        try {
            $url = Url\Repository::getFromShort($assign);

            $resultData['message'] = $url;
        } catch (\Exception $e) {
            throw new ApplicationException($e->getMessage(), $e->getCode());
        }

        return ['message' => $url];
    }
}
